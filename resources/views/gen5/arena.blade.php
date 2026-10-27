<!doctype html>
<html lang="km"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}"><title>GEN5 · {{ $initial['match']['title'] }}</title><link rel="icon" href="{{ asset('favicon.ico') }}"><link rel="stylesheet" href="{{ asset('css/gen5.css') }}?v={{ filemtime(public_path('css/gen5.css')) }}"></head>
<body class="gen5-arena {{ $screen ? 'gen5-projector' : '' }}">
<header class="gen5-top"><a class="gen5-wordmark" href="{{ route($admin ? 'admin.gen5.index' : 'gen5.index') }}">GEN<span>5</span><small>CLASSROOM BATTLEGROUND</small></a><div class="gen5-heading"><h1>{{ $initial['match']['title'] }}</h1><span>{{ $course->code }} · {{ $course->title }}</span></div><div class="gen5-top-actions"><span id="gen5-connection" class="gen5-connection" role="status">Connecting…</span>@if($admin && !$screen)<a href="{{ route('admin.gen5.screen', $initial['match']['id']) }}" target="_blank" rel="noopener">⛶ New tab ↗</a>@endif<button type="button" id="gen5-fullscreen" aria-label="Toggle full screen">⛶ <span>Full screen</span></button><a href="{{ route($admin ? 'admin.gen5.index' : 'gen5.index') }}">← ត្រឡប់</a></div></header>
<main class="gen5-game">
<section class="gen5-scoreboard" aria-label="Live scores"><div class="gen5-team-score team-one"><span class="gen5-team-mark">01</span><div><h2 id="gen5-team-one-name">{{ $initial['match']['team_one'] }}</h2><span id="gen5-team-one-players">0 players</span></div><strong id="gen5-score-one">0</strong></div><div class="gen5-clock"><span id="gen5-status">LOBBY</span><strong id="gen5-timer">--:--</strong><small>អគារពេញលេញ = 1 ពិន្ទុ</small></div><div class="gen5-team-score team-two"><strong id="gen5-score-two">0</strong><div><h2 id="gen5-team-two-name">{{ $initial['match']['team_two'] }}</h2><span id="gen5-team-two-players">0 players</span></div><span class="gen5-team-mark">02</span></div></section>
<div class="gen5-field-header"><span><i class="gen5-dot emerald"></i>ទឹកដីក្រុម 1</span><span>BUILD · CROSS · ATTACK</span><span>ទឹកដីក្រុម 2 <i class="gen5-dot coral"></i></span></div>
<section class="gen5-field" aria-label="GEN5 arena"><canvas id="gen5-board" tabindex="0" aria-label="Game board. Arrow keys or WASD to move. B to build. X to attack. Use the buttons below on a phone."></canvas><div id="gen5-overlay" class="gen5-overlay" hidden><div class="gen5-overlay-card"><span id="gen5-overlay-kicker"></span><h2 id="gen5-overlay-title"></h2><p id="gen5-overlay-description"></p>@unless($admin)<button id="gen5-join" type="button" hidden>ចូលក្រុម / Join match →</button>@endunless</div></div><span class="gen5-border-label" aria-hidden="true">BORDER</span></section>
<div class="gen5-message" id="gen5-message" role="status">កំពុងភ្ជាប់ទៅសមរភូមិ…</div>
@if($admin && !$screen)
<section id="gen5-team-generator" class="gen5-team-generator"><div><strong>ចែកសិស្សក្នុងថ្នាក់ជាពីរក្រុម</strong><p>Generate សិស្សសកម្មទាំងអស់ក្នុងថ្នាក់ ដោយចៃដន្យ។ ចំនួនស្មើគ្នា ឬខុសគ្នាម្នាក់ បើចំនួនសិស្សជាលេខសេស។ អាច Generate ម្ដងទៀតមុន Start។</p></div><button type="button" id="gen5-generate-teams">⇄ Generate teams</button></section>
@endif
@if($admin)
<section class="gen5-admin-controls"><div><span class="gen5-control-label">MATCH CONTROL</span><p>សិស្សចូលក្រុមតាមមុខងារ GEN5 របស់ពួកគេ។</p></div><div class="gen5-admin-buttons"><button data-control="start" class="gen5-start">▶ ចាប់ផ្ដើម</button><button data-control="finish" class="gen5-stop">បញ្ចប់ការប្រកួត</button><button data-control="cancel" class="gen5-cancel">លុបចោល</button></div></section>
@else
<section class="gen5-player-controls" aria-label="Player controls"><div class="gen5-my-team"><span class="gen5-control-label">YOUR TEAM</span><strong id="gen5-my-team">មិនទាន់ចូលក្រុម</strong><span id="gen5-cooldown">Build: B · Attack: X</span></div><div class="gen5-toolset" role="group" aria-label="Choose tool"><button data-mode="move" class="is-selected">↗ ដើរ</button><button data-mode="build">▥ សង់</button><button data-mode="attack">⚒ វាយ</button></div><div class="gen5-dpad" role="group" aria-label="Movement"><button data-move="0,-1" class="up" aria-label="Move up">↑</button><button data-move="-1,0" class="left" aria-label="Move left">←</button><button data-move="0,1" class="down" aria-label="Move down">↓</button><button data-move="1,0" class="right" aria-label="Move right">→</button></div><div class="gen5-quick-actions"><button id="gen5-build-here">▥ សង់ទីនេះ</button><button id="gen5-attack-near">⚒ វាយក្បែរ</button></div></section>
@endif
<section class="gen5-bottom"><div class="gen5-roster-panel"><div class="gen5-panel-heading"><h2>សមាជិកក្រុម</h2><span>{{ $admin ? 'Admin អាចប្ដូរក្រុមនៅក្នុង Lobby' : 'ក្រុមត្រូវបានចែកស្មើគ្នាដោយស្វ័យប្រវត្តិ' }}</span></div><div class="gen5-rosters"><div><h3 class="emerald-text" id="gen5-roster-one-title">TEAM 01</h3><div id="gen5-roster-one"></div></div><div><h3 class="coral-text" id="gen5-roster-two-title">TEAM 02</h3><div id="gen5-roster-two"></div></div></div></div><div class="gen5-events-panel"><div class="gen5-panel-heading"><h2>សកម្មភាពថ្មីៗ</h2><span>LIVE FEED</span></div><ol id="gen5-events"></ol></div></section>
<details class="gen5-instructions"><summary>របៀបលេង / How to play</summary><p>ចុចលើទីតាំងដើម្បីដើរ ឬប្រើ WASD / ព្រួញ។ ជ្រើស «សង់» ឬ «វាយ» ហើយចុចក្រឡាគោលដៅ៖ អ្នកលេងនឹងដើរទៅក្បែរគោលដៅ រួចធ្វើសកម្មភាពមួយដង។ សង់មួយដងបន្ថែមមួយជាន់ ហើយ 3 ជាន់រាប់ជាអគារ 1។ ចុចសង់ម្ដងទៀតរហូតពេញ។ អាចសង់តែនៅទឹកដីក្រុមខ្លួន ហើយអាចឆ្លងព្រំដែនវាយអគារគូប្រកួតបាន។ វាយមួយដងដកមួយជាន់។ អគារខូចអាចសង់ជួសជុលឡើងវិញបាន។</p><p>ចលនាមានចន្លោះពេល {{ \App\Services\Gen5Game::MOVE_MS }} ms ហើយសង់/វាយមានចន្លោះពេល {{ \App\Services\Gen5Game::ACTION_MS }} ms។ ពេលផុតកំណត់ អគារពេញលេញនៅសល់ច្រើនជាងគេឈ្នះ។ ចំនួនស្មើគ្នា = ស្មើ។ ការប្រកួតនេះមិនប៉ះពាល់ដល់ពិន្ទុសិក្សា ឬវិញ្ញាបនបត្រទេ។</p></details>
</main>
@php
    $gen5Config = [
        'initial' => $initial, 'admin' => $admin, 'screen' => $screen,
        'stateUrl' => route('gen5.state', $initial['match']['id']),
        'actionUrl' => $admin ? null : route('gen5.action', $initial['match']['id']),
        'joinUrl' => $admin ? null : route('gen5.join', $initial['match']['id']),
        'controlUrl' => $admin ? route('admin.gen5.control', $initial['match']['id']) : null,
        'generateUrl' => $admin ? route('admin.gen5.generate', $initial['match']['id']) : null,
        'assignBase' => $admin ? url('/admin/gen5/'.$initial['match']['id'].'/players') : null,
    ];
@endphp
<script id="gen5-config" type="application/json">@json($gen5Config)</script>
<script src="{{ asset('js/gen5.js') }}?v={{ filemtime(public_path('js/gen5.js')) }}" defer></script>
</body></html>
