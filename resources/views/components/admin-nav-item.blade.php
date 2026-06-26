@props(['route', 'icon'])

@php
$isActive = request()->routeIs($route . '*');
$classes = $isActive 
            ? 'bg-primary/10 text-primary-dark font-semibold' 
            : 'text-text-secondary hover:bg-gray-50 hover:text-text-primary font-medium';
@endphp

<a href="{{ route($route) }}" {{ $attributes->merge(['class' => "flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors $classes"]) }}>
    @if($icon === 'home')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="{{ $isActive ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="{{ $isActive ? '0' : '2' }}">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
        </svg>
    @endif
    
    {{ $slot }}
</a>
