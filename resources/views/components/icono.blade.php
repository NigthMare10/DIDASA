@props(['nombre', 'clase' => 'h-5 w-5'])

@switch($nombre)
    @case('vehiculo')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 16l1.5-5.5A2 2 0 0 1 8.43 9H15.57a2 2 0 0 1 1.93 1.5L19 16"/><path d="M3 16h18v3a1 1 0 0 1-1 1h-1.5a1.5 1.5 0 0 1-1.5-1.5V18h-10v.5A1.5 1.5 0 0 1 5.5 20H4a1 1 0 0 1-1-1v-3Z"/><circle cx="7.5" cy="16.5" r="1.5"/><circle cx="16.5" cy="16.5" r="1.5"/></svg>
        @break
    @case('documento')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M7 3h7l5 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/><path d="M14 3v5h5"/><path d="M9 13h6M9 17h6M9 9h2"/></svg>
        @break
    @case('calendario')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/></svg>
        @break
    @case('ojo')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"/><circle cx="12" cy="12" r="3"/></svg>
        @break
    @case('escudo')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3l7 3v5c0 5-3 8-7 10-4-2-7-5-7-10V6l7-3Z"/></svg>
        @break
    @case('trofeo')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M8 4h8v4a4 4 0 0 1-8 0V4Z"/><path d="M6 4H4a2 2 0 0 0 2 5M18 4h2a2 2 0 0 1-2 5"/><path d="M12 12v4M9 20h6"/></svg>
        @break
    @case('portapapeles')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="6" y="4" width="12" height="18" rx="2"/><path d="M9 4.5h6a1.5 1.5 0 0 0-3 0 1.5 1.5 0 0 0-3 0Z"/><path d="M9 10h6M9 14h6"/></svg>
        @break
    @case('check-circle')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="m9 12 2 2 4-4"/></svg>
        @break
    @case('campana')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M15 17H5l1.2-1.2A2 2 0 0 0 7 14.39V11a5 5 0 0 1 10 0v3.39a2 2 0 0 0 .8 1.6L19 17h-4"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
        @break
    @case('plus')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 5v14M5 12h14"/></svg>
        @break
    @case('x')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 6l12 12M18 6 6 18"/></svg>
        @break
    @case('chevron-down')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m6 9 6 6 6-6"/></svg>
        @break
    @case('flecha-derecha')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        @break
    @case('flecha-izquierda')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M19 12H5M11 5l-7 7 7 7"/></svg>
        @break
    @case('correo')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg>
        @break
    @case('candado')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="5" y="10" width="14" height="10" rx="2"/><path d="M8 10V8a4 4 0 1 1 8 0v2"/></svg>
        @break
    @case('telefono')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92V20a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 2 4.18 2 2 0 0 1 4 2h3.09a2 2 0 0 1 2 1.72l.45 3.13a2 2 0 0 1-.57 1.73l-1.2 1.2a16 16 0 0 0 6.4 6.4l1.2-1.2a2 2 0 0 1 1.73-.57l3.13.45A2 2 0 0 1 22 16.92Z"/></svg>
        @break
    @case('ubicacion')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 21s6-4.35 6-10a6 6 0 1 0-12 0c0 5.65 6 10 6 10Z"/><circle cx="12" cy="11" r="2"/></svg>
        @break
    @case('reloj')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
        @break
    @case('llave')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 7a4 4 0 1 1 1.17 2.83L9 16v3H6v-3l6.17-6.17A4 4 0 0 1 14 7Z"/><path d="M7 16h2v2"/></svg>
        @break
    @case('freno')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="2.5"/></svg>
        @break
    @case('suspension')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m8 4-3 3 3 3M16 20l3-3-3-3M8 20V4M16 4v16"/></svg>
        @break
    @case('rayo')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M13 2 4 14h6l-1 8 9-12h-6l1-8Z"/></svg>
        @break
    @case('clima')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3v3M12 18v3M4.93 4.93l2.12 2.12M16.95 16.95l2.12 2.12M3 12h3M18 12h3M4.93 19.07l2.12-2.12M16.95 7.05l2.12-2.12"/><circle cx="12" cy="12" r="4"/></svg>
        @break
    @case('alineacion')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="3"/></svg>
        @break
    @case('diagnostico')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="6" width="10" height="12" rx="2"/><path d="M14 10h6v8a2 2 0 0 1-2 2h-4"/></svg>
        @break
    @case('medalla')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="m10 12-2 9 4-3 4 3-2-9"/></svg>
        @break
    @case('estrella')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m12 3 2.7 5.47 6.03.88-4.36 4.24 1.03 5.99L12 16.77l-5.4 2.84 1.03-5.99L3.27 9.35l6.03-.88L12 3Z"/></svg>
        @break
    @case('corona')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m3 8 4 4 5-7 5 7 4-4-2 11H5L3 8Z"/></svg>
        @break
    @case('sparkles')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m12 3 1.8 4.2L18 9l-4.2 1.8L12 15l-1.8-4.2L6 9l4.2-1.8L12 3Z"/><path d="m5 16 .9 2.1L8 19l-2.1.9L5 22l-.9-2.1L2 19l2.1-.9L5 16Zm14-2 .9 2.1L22 17l-2.1.9L19 20l-.9-2.1L16 17l2.1-.9L19 14Z"/></svg>
        @break
    @case('plane')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m3 11 18-8-5 18-3-7-7-3Z"/></svg>
        @break
    @case('descargar')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3v12"/><path d="m7 10 5 5 5-5"/><path d="M5 21h14"/></svg>
        @break
    @case('basura')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 7h16"/><path d="m10 11 0 6"/><path d="m14 11 0 6"/><path d="M6 7l1 12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2l1-12"/><path d="M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/></svg>
        @break
    @case('salud')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 3h3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3"/><path d="M14 3v5h5"/><path d="M5 8h4"/><path d="M7 6v4"/><path d="M5 15a3 3 0 0 0 6 0c0-3-3-5-3-5s-3 2-3 5Z"/></svg>
        @break
    @case('calculator')
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="5" y="3" width="14" height="18" rx="2"/><path d="M8 7h8M8 11h2M12 11h2M16 11h0M8 15h2M12 15h2M16 15h0M8 19h2M12 19h2M16 19h0"/></svg>
        @break
    @default
        <svg {{ $attributes->class([$clase]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 8v8M8 12h8"/></svg>
@endswitch
