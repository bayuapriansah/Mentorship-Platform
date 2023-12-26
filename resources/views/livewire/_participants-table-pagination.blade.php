<div class="max-w-[50%] ml-auto flex items-center text-sm">
    @if ($paginator->hasPages())
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span>
                Prev
            </span>
        @else
            <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev" class="hover:underline">
                Prev
            </button>
        @endif

        {{-- Pagination Elements --}}
        <div class="mx-3 flex items-center gap-4">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span>{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page === $paginator->currentPage())
                            <span class="text-dark-blue font-bold">
                                {{ $page }}
                            </span>
                        @else
                            {{-- <button wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled" class="hover:underline">
                                {{ $page }}
                            </button> --}}
                            <a href="?page={{ $page }}" class="hover:underline">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <button wire:click="nextPage" wire:loading.attr="disabled" rel="next" class="hover:underline">
                Next
            </button>
        @else
            <span>
                Next
            </span>
        @endif
    @endif
</div>
