@if ($paginator->hasPages())
    <div class="table__bottom">
        <div class="paginations paginations--style3 mt-3">
            <ul class="lab-ul d-flex flex-wrap justify-content-end mb-0">
                @if ($paginator->onFirstPage())
                    <li aria-disabled="true">
                        <a href="#"><i class="fa-solid fa-angle-left me-2"></i> </a>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->previousPageUrl() }}" class="active"><i class="fa-solid fa-angle-left me-2"></i> </a>
                    </li>
                @endif



                @foreach ($elements as $element)

                    @if (is_string($element))
                        <li aria-disabled="true">
                            <span class="">{{ $element }}</span>
                        </li>
                    @endif

                    @if(is_array($element))
                        @foreach ($element as $page => $url)
                        <li class="d-none d-sm-block active">
                            @if ($page == $paginator->currentPage())
                                <a class="active" href="{{ $url }}">{{ $page }}</a>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        </li>
                        @endforeach
                    @endif

                @endforeach
                
                {{-- <li>
                    <a href="#" class="dot">...</a>
                </li> --}}

                @if($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}" class="active"><i class="fa-solid fa-angle-right ms-2"></i> </a>
                    </li>
                @else
                    <li aria-disabled="true">
                        <a href="#"><i class="fa-solid fa-angle-right ms-2"></i> </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
@endif
