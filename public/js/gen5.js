(() => {
    'use strict';
    const config = JSON.parse(document.getElementById('gen5-config').textContent);
    const canvas = document.getElementById('gen5-board');
    const ctx = canvas.getContext('2d');
    const $ = id => document.getElementById(`gen5-${id}`);
    const colors = {1: '#55e2b0', 2: '#ff896f'};
    const W = 1040, H = 660, tile = 50, ox = 20, oy = 40;
    const reducedMotion = matchMedia('(prefers-reduced-motion: reduce)').matches;
    let state, receivedAt = performance.now(), lastSuccess = performance.now();
    let busy = false, stopped = false, mode = 'move', intent = null, hover = null;
    let held = null, pollTimer, rosterKey = '', eventKey = '', displayedRevision = -1;
    const visuals = new Map();
    const message = (text, error = false) => { $('message').textContent = text; $('message').classList.toggle('is-error', error); };
    const serverNow = () => state.server_time + performance.now() - receivedAt;
    const connected = () => performance.now() - lastSuccess < 5000;
    const playable = () => !config.admin && state?.me && state.match.status === 'live' && connected();
    const distance = (a, b) => Math.abs(a.x - b.x) + Math.abs(a.y - b.y);
    const teamName = team => team === 1 ? state.match.team_one : state.match.team_two;

    async function request(url, data = null) {
        const controller = new AbortController();
        const timeout = setTimeout(() => controller.abort(), 7000);
        try {
            const response = await fetch(url, {
                method: data === null ? 'GET' : 'POST', credentials: 'same-origin', cache: 'no-store',
                signal: controller.signal,
                headers: {'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
                ...(data === null ? {} : {body: JSON.stringify(data)}),
            });
            let result;
            try { result = await response.json(); } catch { throw new Error('មិនអាចភ្ជាប់បាន។ សូម Refresh ឬចូលគណនីឡើងវិញ។'); }
            if (result.state) update(result.state);
            if (!response.ok) {
                if ([401, 403, 419].includes(response.status)) { stopped = true; intent = null; held = null; }
                const error = new Error(result.error || Object.values(result.errors || {}).flat()[0] || result.message || 'សូមព្យាយាមម្ដងទៀត។');
                error.cooldown = response.status === 429;
                throw error;
            }
            lastSuccess = performance.now();
            return result;
        } finally { clearTimeout(timeout); }
    }

    function update(next) {
        if (state && Number(next.revision) < Number(state.revision)) return;
        const previousStatus = state?.match.status;
        const now = performance.now();
        next.players.forEach(player => {
            const old = visuals.get(player.id);
            if (!old) visuals.set(player.id, {x: player.x, y: player.y, tx: player.x, ty: player.y, at: now});
            else if (old.tx !== player.x || old.ty !== player.y) {
                const t = reducedMotion ? 1 : Math.min(1, (now - old.at) / 190);
                visuals.set(player.id, {x: old.x + (old.tx - old.x) * t, y: old.y + (old.ty - old.y) * t, tx: player.x, ty: player.y, at: now});
            }
        });
        const ids = new Set(next.players.map(p => p.id));
        for (const id of visuals.keys()) if (!ids.has(id)) visuals.delete(id);
        state = next; receivedAt = now;
        $('score-one').textContent = state.scores[1]; $('score-two').textContent = state.scores[2];
        $('team-one-name').textContent = state.match.team_one; $('team-two-name').textContent = state.match.team_two;
        $('team-one-players').textContent = `${state.players.filter(p => p.team === 1).length} players`;
        $('team-two-players').textContent = `${state.players.filter(p => p.team === 2).length} players`;
        $('status').textContent = {lobby:'WAITING ROOM', live:'LIVE MATCH', finished:'MATCH COMPLETE', cancelled:'CANCELLED'}[state.match.status];
        document.body.dataset.matchStatus = state.match.status;
        if (!config.admin) {
            $('my-team').textContent = state.me ? teamName(state.me.team) : 'មិនទាន់ចូលក្រុម';
            $('my-team').style.color = state.me ? colors[state.me.team] : '';
        }
        renderRoster(); renderEvents(); renderOverlay();
        document.querySelectorAll('[data-control]').forEach(button => {
            const action = button.dataset.control;
            button.hidden = action === 'start' ? state.match.status !== 'lobby' : action === 'finish' ? state.match.status !== 'live' : !['lobby','live'].includes(state.match.status);
            button.disabled = busy || (action === 'start' && (!state.players.some(p => p.team === 1) || !state.players.some(p => p.team === 2)));
        });
        if (displayedRevision < 0) message(config.admin ? 'រង់ចាំសិស្សចូលក្រុម រួចចុច «ចាប់ផ្ដើម»។' : 'ចុចគោលដៅដើម្បីដើរ។ ប្រើ B ដើម្បីសង់ និង X ដើម្បីវាយអគារក្បែរខ្លួន។');
        if (state.match.status !== 'live') { intent = null; held = null; }
        if (state.match.status === 'live' && displayedRevision < 0 && config.admin) message('Live spectator · សិស្សទាំងពីរក្រុមកំពុងប្រកួតលើសមរភូមិតែមួយ។');
        if (previousStatus && previousStatus !== state.match.status) {
            message(state.match.status === 'live' ? (config.admin ? 'Live spectator · ការប្រកួតកំពុងដំណើរការ។' : 'ការប្រកួតចាប់ផ្ដើម! សង់អគារ ឬឆ្លងព្រំដែនទៅវាយ។') : state.match.status === 'finished' ? 'ចប់ម៉ោង! លទ្ធផលត្រូវបានចាក់សោនៅ server។' : 'ការប្រកួតត្រូវបានបិទ។');
        }
        displayedRevision = Number(state.revision);
    }

    function renderOverlay() {
        const overlay = $('overlay');
        overlay.hidden = state.match.status === 'live';
        const join = $('join'); if (join) join.hidden = true;
        if (state.match.status === 'lobby') {
            $('overlay-kicker').textContent = 'ASSEMBLE YOUR TEAM';
            $('overlay-title').textContent = 'សមរភូមិកំពុងរង់ចាំ';
            $('overlay-description').textContent = config.admin ? 'ឱ្យសិស្សចូល GEN5 ហើយចូលក្រុម។ ត្រូវមានសិស្សយ៉ាងតិចម្នាក់ក្នុងក្រុមនីមួយៗ មុនចាប់ផ្ដើម។' : state.me ? `អ្នកនៅក្រុម ${teamName(state.me.team)}។ រង់ចាំ Admin ចាប់ផ្ដើមការប្រកួត។` : 'ចូលរួមដើម្បីទទួលក្រុមរបស់អ្នក។ ក្រុមនឹងត្រូវចាក់សោពេលការប្រកួតចាប់ផ្ដើម។';
            if (join && !state.me) join.hidden = false;
        } else if (state.match.status === 'finished') {
            $('overlay-kicker').textContent = 'TIME IS UP';
            $('overlay-title').textContent = Number(state.match.winner) === 0 ? 'ស្មើគ្នា! 🤝' : `${teamName(Number(state.match.winner))} ឈ្នះ! 🏆`;
            $('overlay-description').textContent = `${state.match.team_one} ${state.scores[1]} — ${state.scores[2]} ${state.match.team_two} · អគារពេញលេញដែលនៅសល់ពេលចប់ម៉ោង។`;
        } else if (state.match.status === 'cancelled') {
            $('overlay-kicker').textContent = 'MATCH CLOSED';
            $('overlay-title').textContent = 'ការប្រកួតត្រូវបានលុបចោល';
            $('overlay-description').textContent = 'Admin បានបិទការប្រកួតនេះ។ ត្រឡប់ទៅ GEN5 ដើម្បីរកការប្រកួតថ្មី។';
        }
    }

    function renderRoster() {
        const key = state.match.status + state.players.map(p => `${p.id}:${p.team}:${p.name}`).join('|');
        if (key === rosterKey) return; rosterKey = key;
        [1,2].forEach(team => {
            $(`roster-${team === 1 ? 'one' : 'two'}-title`).textContent = teamName(team);
            const list = $(`roster-${team === 1 ? 'one' : 'two'}`); list.replaceChildren();
            const players = state.players.filter(p => p.team === team);
            if (!players.length) { const empty = document.createElement('p'); empty.className = 'gen5-roster-empty'; empty.textContent = 'កំពុងរង់ចាំសមាជិក…'; list.append(empty); }
            players.forEach(player => {
                const row = document.createElement('div'); row.className = 'gen5-player-row';
                const avatar = document.createElement('span'); avatar.className = `gen5-player-avatar team-${team}`; avatar.textContent = [...player.name][0]?.toUpperCase() || '?';
                const name = document.createElement('span'); name.textContent = player.name + (state.me?.id === player.id ? ' (អ្នក)' : '');
                row.append(avatar, name);
                if (config.admin && state.match.status === 'lobby') {
                    const swap = document.createElement('button'); swap.textContent = '⇄'; swap.title = 'ប្ដូរក្រុម'; swap.setAttribute('aria-label', `Move ${player.name} to team ${team === 1 ? 2 : 1}`);
                    swap.addEventListener('click', async () => { if (busy) return; busy = true; try { update(await request(`${config.assignBase}/${player.id}/team`, {team: team === 1 ? 2 : 1})); } catch (error) { message(error.message, true); } finally { busy = false; } }); row.append(swap);
                }
                list.append(row);
            });
        });
    }

    function renderEvents() {
        const key = JSON.stringify(state.events); if (key === eventKey) return; eventKey = key;
        const list = $('events'); list.replaceChildren();
        const labels = {joined:'បានចូលក្រុម', built:'បានសង់អគារពេញលេញ', attacked:'បានវាយអគារគូប្រកួត', destroyed:'បានបំផ្លាញអគារគូប្រកួត', started:'ការប្រកួតចាប់ផ្ដើម!', finished:'ការប្រកួតបានបញ្ចប់។', cancelled:'ការប្រកួតត្រូវបានលុបចោល។'};
        state.events.slice(0,6).forEach(event => {
            const item = document.createElement('li');
            const dot = document.createElement('i'); dot.style.background = colors[event.team] || '#91a2c3';
            const text = document.createElement('span'); text.textContent = [event.name, labels[event.type]].filter(Boolean).join(' ');
            item.append(dot,text); list.append(item);
        });
        if (!state.events.length) { const li = document.createElement('li'); li.textContent = 'សកម្មភាពនឹងបង្ហាញនៅពេលសិស្សចូលរួម។'; list.append(li); }
    }

    async function poll() {
        if (stopped) return;
        try { update(await request(config.stateUrl)); }
        catch (error) { intent = null; held = null; message(error.message || 'ការភ្ជាប់បានផ្អាក។ កំពុងព្យាយាមភ្ជាប់ឡើងវិញ…', true); }
        finally { if (!stopped) pollTimer = setTimeout(poll, document.hidden ? 2500 : 900); }
    }

    async function perform(action, target) {
        if (busy || !playable()) return false;
        busy = true;
        try {
            await request(config.actionUrl, {action, x:target.x, y:target.y});
            if (action !== 'move') message(action === 'build' ? 'បានបន្ថែមមួយជាន់។ សង់ 3 ជាន់ដើម្បីរាប់ជាអគារ 1។' : 'បានវាយអគារគូប្រកួតមួយជាន់!');
            return true;
        } catch (error) { if (!error.cooldown) { intent = null; held = null; } message(error.message, !error.cooldown); return false; }
        finally { busy = false; }
    }

    function chooseMode(next) {
        mode = next; intent = null;
        document.querySelectorAll('[data-mode]').forEach(button => { button.classList.toggle('is-selected', button.dataset.mode === mode); button.setAttribute('aria-pressed', button.dataset.mode === mode ? 'true' : 'false'); });
        message({move:'ចុចលើទីតាំងដើម្បីដើរ។ អាចឆ្លងព្រំដែនបាន។', build:'ចុចក្រឡានៅទឹកដីខ្លួន។ អ្នកនឹងដើរទៅក្បែរ រួចសង់មួយជាន់។', attack:'ចុចអគារគូប្រកួត។ អ្នកនឹងដើរឆ្លងព្រំដែនទៅវាយ។'}[mode]);
    }

    function buildHere() { if (!playable()) return; intent = {mode:'build', x:state.me.x, y:state.me.y}; }
    function attackNear() {
        if (!playable()) return;
        const target = state.buildings.find(b => b.team !== state.me.team && distance(state.me,b) <= 1);
        if (target) intent = {...target, mode:'attack'};
        else message('មិនមានអគារគូប្រកួតនៅក្បែរទេ។ ដើរឆ្លងព្រំដែនទៅជិតអគារគូប្រកួត។', true);
    }

    document.querySelectorAll('[data-mode]').forEach(button => button.addEventListener('click', () => chooseMode(button.dataset.mode)));
    $('build-here')?.addEventListener('click', buildHere); $('attack-near')?.addEventListener('click', attackNear);
    $('join')?.addEventListener('click', async () => {
        if (busy) return; busy = true;
        try { update(await request(config.joinUrl, {})); message('បានចូលក្រុមរួច។ រង់ចាំ Admin ចាប់ផ្ដើម។'); }
        catch (error) { message(error.message, true); } finally { busy = false; }
    });
    document.querySelectorAll('[data-control]').forEach(button => button.addEventListener('click', async () => {
        if (busy) return;
        const action = button.dataset.control;
        if (action !== 'start' && !confirm(action === 'finish' ? 'បញ្ចប់ការប្រកួតឥឡូវ ហើយកំណត់អ្នកឈ្នះតាមអគារដែលនៅសល់?' : 'លុបចោលការប្រកួតនេះ?')) return;
        busy = true;
        try { await request(config.controlUrl, {action}); message(action === 'start' ? 'ការប្រកួតបានចាប់ផ្ដើម!' : 'ការប្រកួតបានបិទ។'); }
        catch (error) { message(error.message, true); }
        finally { busy = false; update(state); }
    }));
    $('fullscreen').addEventListener('click', async () => {
        try { if (document.fullscreenElement) await document.exitFullscreen(); else await document.documentElement.requestFullscreen(); }
        catch { message('Browser នេះមិនអនុញ្ញាត Full screen។ អាចប្រើប៊ូតុង Full screen របស់ browser។'); }
    });

    function point(event) {
        const rect = canvas.getBoundingClientRect();
        return {x:Math.floor(((event.clientX - rect.left) * W / rect.width - ox) / tile), y:Math.floor(((event.clientY - rect.top) * H / rect.height - oy) / tile)};
    }
    canvas.addEventListener('pointermove', event => { const p = point(event); hover = p.x >= 0 && p.x < 20 && p.y >= 0 && p.y < 12 ? p : null; });
    canvas.addEventListener('pointerleave', () => { hover = null; });
    canvas.addEventListener('pointerdown', event => {
        if (!playable() || event.button > 0) return;
        const p = point(event); if (p.x < 0 || p.x >= 20 || p.y < 0 || p.y >= 12) return;
        event.preventDefault(); canvas.focus({preventScroll:true}); held = null; intent = {...p, mode};
    });
    document.querySelectorAll('[data-move]').forEach(button => {
        button.addEventListener('pointerdown', event => { event.preventDefault(); if (!playable()) return; intent = null; held = button.dataset.move.split(',').map(Number); button.setPointerCapture(event.pointerId); });
        ['pointerup','pointercancel','lostpointercapture'].forEach(type => button.addEventListener(type, () => { held = null; }));
    });
    const directions = {arrowup:[0,-1],w:[0,-1],arrowdown:[0,1],s:[0,1],arrowleft:[-1,0],a:[-1,0],arrowright:[1,0],d:[1,0]};
    window.addEventListener('keydown', event => {
        if (!playable() || event.ctrlKey || event.metaKey || event.altKey || /INPUT|TEXTAREA|SELECT/.test(event.target.tagName)) return;
        const key = event.key.toLowerCase();
        if (directions[key]) { event.preventDefault(); held = directions[key]; intent = null; }
        else if (key === 'b') { event.preventDefault(); if (!event.repeat) buildHere(); }
        else if (key === 'x') { event.preventDefault(); if (!event.repeat) attackNear(); }
    });
    window.addEventListener('keyup', event => { if (directions[event.key.toLowerCase()]) held = null; });
    window.addEventListener('blur', () => { held = null; intent = null; });
    document.addEventListener('visibilitychange', () => { if (document.hidden) { held = null; intent = null; } });
    window.addEventListener('pagehide', () => { stopped = true; clearTimeout(pollTimer); });

    setInterval(() => {
        if (!playable() || busy) return;
        const me = state.me;
        if (held) {
            if (serverNow() < Number(me.next_move_at) + 25) return;
            const target = {x:me.x + held[0], y:me.y + held[1]};
            if (target.x >= 0 && target.x < 20 && target.y >= 0 && target.y < 12) perform('move',target);
            return;
        }
        if (!intent) return;
        const d = distance(me,intent);
        if (intent.mode === 'move' && d === 0) { intent = null; return; }
        if (intent.mode !== 'move' && d <= 1) {
            if (serverNow() < Number(me.next_action_at) + 25) return;
            const task = intent; intent = null; perform(task.mode,task); return;
        }
        if (serverNow() < Number(me.next_move_at) + 25) return;
        const dx = intent.x - me.x, dy = intent.y - me.y;
        const next = Math.abs(dx) >= Math.abs(dy) && dx !== 0 ? {x:me.x + Math.sign(dx), y:me.y} : {x:me.x,y:me.y + Math.sign(dy)};
        perform('move',next);
    }, 65);

    setInterval(() => {
        if (!state) return;
        const sync = connected() && !stopped;
        $('connection').textContent = sync ? '● Synced' : '● Reconnecting';
        $('connection').classList.toggle('is-offline', !sync);
        const ms = state.match.status === 'lobby' ? state.match.duration_minutes * 60000 : state.match.status === 'live' ? Math.max(0,state.match.ends_at - serverNow()) : 0;
        const seconds = Math.ceil(ms / 1000);
        $('timer').textContent = `${String(Math.floor(seconds / 60)).padStart(2,'0')}:${String(seconds % 60).padStart(2,'0')}`;
        $('timer').classList.toggle('is-urgent', state.match.status === 'live' && seconds <= 30);
        if (!config.admin) {
            document.querySelectorAll('.gen5-player-controls button').forEach(button => { button.disabled = !playable(); });
        }
        if (!config.admin && state.me) {
            const cooldown = Math.max(0,Number(state.me.next_action_at) - serverNow());
            $('cooldown').textContent = cooldown > 0 ? `Tool ready in ${(cooldown / 1000).toFixed(1)}s` : 'Tool ready · B សង់ · X វាយ';
        }
    }, 100);

    function polygon(points, fill, stroke = null) {
        ctx.beginPath(); points.forEach(([x,y],i) => i ? ctx.lineTo(x,y) : ctx.moveTo(x,y)); ctx.closePath();
        ctx.fillStyle = fill; ctx.fill(); if (stroke) { ctx.strokeStyle = stroke; ctx.lineWidth = 1; ctx.stroke(); }
    }
    function building(b) {
        const cx = ox + b.x * tile + 25, base = oy + b.y * tile + 35, height = b.height * 12;
        const one = b.team === 1;
        ctx.fillStyle = '#00000025'; ctx.beginPath(); ctx.ellipse(cx+6,base+2,20,7,0,0,Math.PI*2); ctx.fill();
        polygon([[cx-14,base-7],[cx,base+1],[cx,base-height+1],[cx-14,base-height-7]], one?'#218a70':'#ab514b');
        polygon([[cx,base+1],[cx+14,base-7],[cx+14,base-height-7],[cx,base-height+1]],one?'#3ac39b':'#ee806b');
        polygon([[cx-14,base-height-7],[cx,base-height-15],[cx+14,base-height-7],[cx,base-height+1]],one?'#86f4cc':'#ffc5ad');
        for(let floor=0;floor<b.height;floor++) {
            ctx.fillStyle = one?'#bbffde':'#ffe0bd';
            ctx.fillRect(cx-10,base-floor*12-10,3,4); ctx.fillRect(cx-5,base-floor*12-7,3,4);
            ctx.fillRect(cx+3,base-floor*12-6,3,4); ctx.fillRect(cx+8,base-floor*12-9,3,4);
        }
        if(b.height === state.world.build_height) {
            ctx.strokeStyle='#d5e4e7'; ctx.lineWidth=1.5; ctx.beginPath(); ctx.moveTo(cx,base-height-10); ctx.lineTo(cx,base-height-24); ctx.stroke();
            polygon([[cx,base-height-24],[cx+10,base-height-20],[cx,base-height-16]],colors[b.team]);
        } else {
            for(let i=0;i<3;i++) { ctx.fillStyle=i<b.height?colors[b.team]:'#ffffff25'; ctx.fillRect(cx-11+i*8,base+8,6,3); }
        }
    }

    function draw(time) {
        const dpr = Math.min(devicePixelRatio || 1,2);
        const width = Math.max(1,Math.round(canvas.clientWidth * dpr)), height = Math.max(1,Math.round(canvas.clientHeight * dpr));
        if(canvas.width !== width || canvas.height !== height) { canvas.width=width; canvas.height=height; }
        ctx.setTransform(width/W,0,0,height/H,0,0); ctx.clearRect(0,0,W,H);
        ctx.fillStyle='#101d30'; ctx.fillRect(0,0,W,H);
        if(state) {
            for(let y=0;y<12;y++) for(let x=0;x<20;x++) {
                ctx.fillStyle=x<10?((x+y)%2?'#16372f':'#173c33'):((x+y)%2?'#392c30':'#3e2e32');
                ctx.fillRect(ox+x*tile,oy+y*tile,tile,tile);
                ctx.strokeStyle='#b0dbcc08'; ctx.lineWidth=1; ctx.strokeRect(ox+x*tile,oy+y*tile,tile,tile);
            }
            ctx.font='bold 170px system-ui'; ctx.textAlign='center'; ctx.fillStyle='#55e2b008'; ctx.fillText('01',ox+250,oy+350); ctx.fillStyle='#ff896f08'; ctx.fillText('02',ox+750,oy+350);
            ctx.save();ctx.setLineDash([8,9]);ctx.strokeStyle='#a8b7c868';ctx.lineWidth=2;ctx.beginPath();ctx.moveTo(ox+500,oy);ctx.lineTo(ox+500,oy+600);ctx.stroke();ctx.restore();
            const target = intent || hover;
            if(target && !config.admin) {
                ctx.fillStyle = mode === 'attack' ? '#ff8a6e24' : '#ffffff15'; ctx.fillRect(ox+target.x*tile,oy+target.y*tile,tile,tile);
                ctx.strokeStyle=mode==='attack'?colors[2]:'#e0edff88';ctx.lineWidth=2;ctx.strokeRect(ox+target.x*tile+2,oy+target.y*tile+2,tile-4,tile-4);
            }
            state.buildings.slice().sort((a,b)=>a.y-b.y || a.x-b.x).forEach(building);
            state.players.forEach(player => {
                const v = visuals.get(player.id); if(!v)return;
                const t = reducedMotion?1:Math.min(1,(time-v.at)/190);
                const x=ox+(v.x+(v.tx-v.x)*t)*tile+25+(player.id%3-1)*5;
                const y=oy+(v.y+(v.ty-v.y)*t)*tile+24+(player.id%2)*4;
                const mine=state.me?.id===player.id;
                ctx.fillStyle='#00000035';ctx.beginPath();ctx.ellipse(x,y+10,12,5,0,0,Math.PI*2);ctx.fill();
                if(mine) {ctx.strokeStyle='#fff';ctx.lineWidth=2;ctx.beginPath();ctx.arc(x,y,15,0,Math.PI*2);ctx.stroke();}
                ctx.fillStyle=colors[player.team];ctx.beginPath();ctx.arc(x,y,10,0,Math.PI*2);ctx.fill();
                ctx.strokeStyle='#102334';ctx.lineWidth=2;ctx.stroke();ctx.fillStyle='#142d30';ctx.font='bold 10px system-ui';ctx.textAlign='center';ctx.textBaseline='middle';ctx.fillText([...player.name][0]?.toUpperCase()||'?',x,y+.5);
                if(mine){ctx.fillStyle='#f1f7ff';ctx.font='bold 8px system-ui';ctx.fillText('YOU',x,y-23);}
            });
            ctx.textBaseline='alphabetic';
        }
        if(!stopped) requestAnimationFrame(draw);
    }
    update(config.initial); requestAnimationFrame(draw); poll();
})();
