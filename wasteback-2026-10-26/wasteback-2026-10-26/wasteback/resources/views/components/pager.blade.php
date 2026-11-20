@props(['items'])
@if ($items->hasPages())
    <div class="pagination-wrap">
        <nav aria-label="Pagination">
            <span class="muted">Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{ $items->total() }}</span>
            <span class="pager">
                @if ($items->onFirstPage())
                    <span class="off">Previous</span>
                @else
                    <a href="{{ $items->previousPageUrl() }}">Previous</a>
                @endif
                <span class="on">{{ $items->currentPage() }}</span>
                @if ($items->hasMorePages())
                    <a href="{{ $items->nextPageUrl() }}">Next</a>
                @else
                    <span class="off">Next</span>
                @endif
            </span>
        </nav>
    </div>
@endif
