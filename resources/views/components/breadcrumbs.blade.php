@props(['items' => []])

@if(!empty($items))
<nav aria-label="Breadcrumb" class="py-4">
    <ol class="flex flex-wrap items-center gap-2 text-xs font-body text-soft-gray">
        <li>
            <a href="{{ url('/') }}" class="flex items-center gap-1.5 hover:text-primary transition-colors">
                <svg class="w-4 h-4 text-primary-light" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                <span>Home</span>
            </a>
        </li>

        @foreach($items as $item)
            <li class="flex items-center gap-2">
                <svg class="w-3.5 h-3.5 text-primary-light/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>

                @if(!empty($item['url']) && !$loop->last)
                    <a href="{{ $item['url'] }}" class="hover:text-primary transition-colors">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="text-charcoal font-semibold" aria-current="page">
                        {{ $item['label'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
@endif
