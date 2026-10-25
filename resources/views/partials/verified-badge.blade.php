@php
    $bSize = $size ?? 16;
    $bBorder = isset($border) ? $border : true;
@endphp
<span class="d-inline-flex align-items-center justify-content-center flex-shrink-0 align-middle {{ $class ?? '' }}" title="គណនីសិស្សផ្លូវការ (Verified Account)" data-bs-toggle="tooltip" data-bs-title="គណនីសិស្សផ្លូវការ (Verified Student)" style="vertical-align: middle;">
    <svg viewBox="0 0 16 16" width="{{ $bSize }}" height="{{ $bSize }}" class="flex-shrink-0" style="filter: drop-shadow(0 1px 2px rgba(0,0,0,0.22));" xmlns="http://www.w3.org/2000/svg">
        <path fill="#1877F2" @if($bBorder) stroke="#ffffff" stroke-width="0.75" stroke-linejoin="round" @endif d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01z"/>
        <path fill="#ffffff" d="M10.354 6.854a.5.5 0 0 0-.708-.708L7 8.793 5.354 7.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0z"/>
    </svg>
</span>