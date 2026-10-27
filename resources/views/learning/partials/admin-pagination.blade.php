@if($paginator->hasPages())
<nav class="admin-pagination" aria-label="{{ $label }} pagination"><span>{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} / {{ $paginator->total() }}</span><div>@if($paginator->onFirstPage())<span class="page-disabled">← Previous</span>@else<a href="{{ $paginator->previousPageUrl() }}">← Previous</a>@endif<span class="page-number">{{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>@if($paginator->hasMorePages())<a href="{{ $paginator->nextPageUrl() }}">Next →</a>@else<span class="page-disabled">Next →</span>@endif</div></nav>
@endif
