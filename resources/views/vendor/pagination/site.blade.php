@if ($paginator->hasPages())
    <!-- Pagination -->
    <div class="text-center content-group-lg pt-20">
        <ul class="pagination">
    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="disabled"><a href="#"><i class="icon-arrow-small-left"></i></a></li>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
            <li class="active"><a  href="{{ $url }}">{{ $page }}</a></li>
            @else
            <li><a  href="{{ $url }}">{{ $page }}</a></li>
            @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages()) 
            <li><a href="{{ $paginator->nextPageUrl() }}"><i class="icon-arrow-small-left"></i></a></li>
            @else          
            @endif
        </ul>
    </div>
    <!-- /pagination -->
@endif