@if ($items->hasPages())
    <div class="px-6 py-4 border-t border-primary-light/10 bg-background/30">
        {{ $items->links() }}
    </div>
@endif
