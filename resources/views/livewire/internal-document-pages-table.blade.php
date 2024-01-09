<div x-data="{ showFilters: false }">
    {{-- Search and Filters --}}
    <div class="flex justify-end gap-14">
        <button x-on:click="showFilters = !showFilters" type="button" class="flex items-center gap-4">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_4295_8096)">
                    <path d="M8.33333 15H11.6667V13.3333H8.33333V15ZM2.5 5V6.66667H17.5V5H2.5ZM5 10.8333H15V9.16667H5V10.8333Z" fill="#E96424"/>
                </g>
                <defs>
                    <clipPath id="clip0_4295_8096">
                    <rect width="20" height="20" fill="white"/>
                    </clipPath>
                </defs>
            </svg>
            <span class="text-sm">
                Filters
            </span>
        </button>

        <div class="relative">
            <input
                wire:model="search"
                type="text"
                placeholder="Search here"
                class="w-[403px] h-[42px] pr-12 rounded-xl border border-grey"
            >

            <button type="button" class="{{ $search === '' ? 'block' : 'hidden' }} absolute top-2 right-4 text-light-brown">
                <i class="fas fa-search fa-lg"></i>
            </button>

            <button
                type="button"
                wire:click="resetSearch"
                class="{{ $search === '' ? 'hidden' : 'block' }} absolute top-2 right-4 text-light-brown"
            >
                <i class="far fa-times-circle fa-lg"></i>
            </button>
        </div>
    </div>

    <div x-cloak x-show="showFilters" x-transition class="mt-6 mb-10">
        <div class="flex flex-wrap gap-x-8 gap-y-6">
            {{-- Sort by --}}
            <div class="flex flex-col gap-4">
                <h2 class="text-lg text-darker-blue">
                    Sort by
                </h2>

                <div class="flex items-center gap-4">
                    <select wire:model="sortField" class="text-sm border border-primary rounded-md">
                        @foreach ($sortOptions as $key => $value)
                            <option value="{{ $key }}">
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>

                    <select wire:model="sortDirection" class="text-sm border border-primary rounded-md">
                        <option value="asc">
                            A - Z
                        </option>
                        <option value="desc">
                            Z - A
                        </option>
                    </select>
                </div>
            </div>
            {{-- Sort by --}}
        </div>
    </div>
    {{-- ./Search and Filters --}}

    {{-- Table --}}
    <div class="mt-4 px-6 pt-2 pb-4 rounded-2xl border border-grey">
        <div class="relative overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-y-4">
                <thead>
                    <tr>
                        <th scope="col" class="pr-8 pl-5">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-darker-blue font-medium">
                                    Page Title
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="pr-8">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-darker-blue font-medium">
                                    Group Section
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="pr-8">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-darker-blue font-medium">
                                    Release Date
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="pr-8">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-darker-blue font-medium">
                                    Status
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="pr-8">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-darker-blue font-medium">
                                    Actions
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="pr-5">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-darker-blue font-medium">
                                    View
                                </span>
                            </div>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($internalDocumentPages as $doc_page)
                        <tr class="{{ $loop->iteration % 2 === 0 ? 'bg-[#EBEDFF]' : 'bg-[#F8F8F8]' }}">
                            <td class="pr-8 pl-5 py-2 rounded-s-lg">
                                {{ $doc_page->title }}
                            </td>

                            <td class="pr-8 py-2">
                                {{ $doc_page->internalDocumentGroupSection->name }}
                            </td>

                            <td class="pr-8 py-2">
                                {{ $doc_page->created_at->format('d/m/Y') }}
                            </td>

                            <td class="pr-8 py-2">
                                <div class="dropdown inline-block relative">
                                    <button type="button" class="w-32 px-2.5 py-1 bg-primary rounded-lg flex justify-between items-center text-sm text-white">
                                        {{ $doc_page->is_draft ? 'Draft' : 'Published' }}

                                        <i class="fas fa-chevron-down"></i>
                                    </button>

                                    <div class="z-10 dropdown-menu absolute right-0 hidden border border-light-blue bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                        <ul class="py-2 text-sm text-gray-700">
                                            <li class="w-full cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <button
                                                    type="button"
                                                    wire:click="publishPage({{ $doc_page->id }})"
                                                    class="w-full text-center text-sm"
                                                >
                                                    Publish
                                                </button>
                                            </li>

                                            <li class="w-full cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <button
                                                    type="button"
                                                    wire:click="draftPage({{ $doc_page->id }})"
                                                    class="w-full text-center text-sm"
                                                >
                                                    Draft
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>

                            <td class="pr-8 py-2">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('dashboard.internal-document.all-pages.edit', ['id' => $doc_page->id]) }}" title="Edit">
                                        <i class="fas fa-pen text-darker-blue"></i>
                                    </a>

                                    <button
                                        type="button"
                                        title="Delete"
                                        onclick="confirmDelete('{{ $doc_page->id }}')"
                                    >
                                        <i class="fas fa-trash-alt text-red-600"></i>
                                    </button>
                                </div>
                            </td>

                            <td class="pr-5 py-2 rounded-e-lg">
                                <a href="#" class="">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{--./Table --}}

    {{-- Pagination --}}
    <div class="mt-5 px-2 flex items-center">
        <div class="ml-auto">
            {{ $internalDocumentPages->links() }}
        </div>
    </div>
    {{-- ./Pagination --}}

    {{-- Confirm Delete Modal --}}
    <button
        hidden
        id="open-confirm-delete-modal-btn"
        type="button"
        data-modal-target="confirm-delete-modal"
        data-modal-toggle="confirm-delete-modal"
    ></button>

    <div wire:ignore id="confirm-delete-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white border-2 border-grey rounded-xl">
                <div
                    class="absolute top-0 right-0 w-[110px] h-[110px]"
                    style="background: url({{ asset('/assets/img/dots-2.png') }}), transparent -0.072px -7.605px / 181.04% 106.977% no-repeat;"
                ></div>

                <!-- Modal body -->
                <div class="px-24 pt-12 pb-14">
                    <input type="hidden" id="delete-page-id" value="">

                    <p class="text-center text-[1.375rem] text-darker-blue font-medium">
                        Are you sure you want to delete this page?
                    </p>

                    <p class="mt-4 text-center text-lg">
                        Pages that have been deleted cannot be restored.
                    </p>

                    <div class="mt-7 flex justify-center items-center gap-6">
                        <button type="button" id="delete-page-btn" class="min-w-[101px] p-2 bg-primary rounded-full text-sm text-white">
                            Yes
                        </button>

                        <button type="button" id="hide-delete-modal-btn" data-modal-hide="confirm-delete-modal" class="min-w-[101px] p-2 border border-primary rounded-full text-sm text-primary">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ./Confirm Delete Modal --}}

    <script>
        function confirmDelete(id) {
            document.getElementById('delete-page-id').value = id
            document.getElementById('open-confirm-delete-modal-btn').click()
        }

        document.addEventListener('livewire:load', function () {
            document.getElementById('delete-page-btn').addEventListener('click', function () {
                const pageId = document.getElementById('delete-page-id').value

                @this.call('deletePage', pageId)
                    .then(() => {
                        document.getElementById('hide-delete-modal-btn').click()
                    })
            })
        })

        document.getElementById('hide-delete-modal-btn').addEventListener('click', () => {
            document.getElementById('delete-page-id').value = ''
        })
    </script>
</div>
