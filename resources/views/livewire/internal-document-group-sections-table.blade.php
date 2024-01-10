<div x-data="{ showFilters: false }">
    <div class="flex justify-between items-center">
        <h1 class="text-dark-blue font-medium text-[1.375rem]">
            Internal Document
            <span class="mx-3">></span>
            Group Section
        </h1>

        <button
            type="button"
            data-modal-target="add-modal"
            data-modal-toggle="add-modal"
            class="flex items-center gap-3 text-xl text-dark-blue"
        >
            <i class="fas fa-plus-circle mt-1 text-primary"></i>
            Group Section
        </button>
    </div>

    {{-- Search and Filters --}}
    <div class="mt-6 flex justify-end gap-14">
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
                                    Group Name
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
                                    Action
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
                    @foreach ($internalDocumentGroupSections as $section)
                        <tr class="{{ $loop->iteration % 2 === 0 ? 'bg-[#EBEDFF]' : 'bg-[#F8F8F8]' }}">
                            <td class="pr-8 pl-5 py-2 rounded-s-lg">
                                {{ $section->name }}
                            </td>

                            <td class="pr-8 py-2">
                                <div class="dropdown inline-block relative">
                                    <button type="button" class="w-32 px-2.5 py-1 bg-primary rounded-lg flex justify-between items-center text-sm text-white">
                                        {{ $section->is_draft ? 'Draft' : 'Published' }}

                                        <i class="fas fa-chevron-down"></i>
                                    </button>

                                    <div class="z-10 dropdown-menu absolute right-0 hidden border border-light-blue bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                        <ul class="py-2 text-sm text-gray-700">
                                            <li class="w-full cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <button
                                                    type="button"
                                                    wire:click="publishSection({{ $section->id }})"
                                                    class="w-full text-center text-sm"
                                                >
                                                    Publish
                                                </button>
                                            </li>

                                            <li class="w-full cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <button
                                                    type="button"
                                                    wire:click="draftSection({{ $section->id }})"
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
                                    <button
                                        type="button"
                                        title="Edit"
                                        onclick="editSection('{{ $section->id }}', '{{ $section->name }}')"
                                    >
                                        <i class="fas fa-pen text-darker-blue"></i>
                                    </button>

                                    <button
                                        type="button"
                                        title="Delete"
                                        onclick="confirmDelete('{{ $section->id }}')"
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
            {{ $internalDocumentGroupSections->links() }}
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
                    <input type="hidden" id="delete-section-id" value="">

                    <p class="text-center text-[1.375rem] text-darker-blue font-medium">
                        Are you sure you want to delete this group section and all of its pages?
                    </p>

                    <p class="mt-4 text-center text-lg">
                        Group sections that have been deleted cannot be restored.
                    </p>

                    <div class="mt-7 flex justify-center items-center gap-6">
                        <button type="button" id="delete-section-btn" class="min-w-[101px] p-2 bg-primary rounded-full text-sm text-white">
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

    {{-- Add Modal --}}
    <div wire:ignore id="add-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white border-2 border-grey rounded-xl">
                <div
                    class="absolute top-0 right-0 w-[110px] h-[110px]"
                    style="background: url({{ asset('/assets/img/dots-2.png') }}), transparent -0.072px -7.605px / 181.04% 106.977% no-repeat;"
                ></div>

                <!-- Modal body -->
                <div class="px-24 pt-12 pb-14">
                    <p class="text-center text-[1.375rem] text-darker-blue font-medium">
                        Add a New Group Section
                    </p>

                    <input
                        type="text"
                        id="input-new-section"
                        placeholder="Group Section Name. . ."
                        class="w-full mt-8 h-11 px-4 py-2 border border-grey rounded-lg leading-tight focus:outline-none"
                    >

                    <div class="mt-7 flex justify-center items-center gap-6">
                        <button type="button" id="save-btn" class="min-w-[101px] p-2 bg-primary rounded-full text-sm text-white">
                            Save
                        </button>

                        <button type="button" id="hide-add-modal-btn" data-modal-hide="add-modal" class="min-w-[101px] p-2 border border-primary rounded-full text-sm text-primary">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ./Add Modal --}}

    {{-- Edit Modal --}}
    <button
        hidden
        id="open-edit-modal-btn"
        type="button"
        data-modal-target="edit-modal"
        data-modal-toggle="edit-modal"
    ></button>

    <div wire:ignore id="edit-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white border-2 border-grey rounded-xl">
                <div
                    class="absolute top-0 right-0 w-[110px] h-[110px]"
                    style="background: url({{ asset('/assets/img/dots-2.png') }}), transparent -0.072px -7.605px / 181.04% 106.977% no-repeat;"
                ></div>

                <!-- Modal body -->
                <div class="px-24 pt-12 pb-14">
                    <p class="text-center text-[1.375rem] text-darker-blue font-medium">
                        Edit Group Section
                    </p>

                    <input type="hidden" id="input-edit-section-id">

                    <input
                        type="text"
                        id="input-edit-section-name"
                        placeholder="Group Section Name. . ."
                        class="w-full mt-8 h-11 px-4 py-2 border border-grey rounded-lg leading-tight focus:outline-none"
                    >

                    <div class="mt-7 flex justify-center items-center gap-6">
                        <button type="button" id="update-btn" class="min-w-[101px] p-2 bg-primary rounded-full text-sm text-white">
                            Update
                        </button>

                        <button type="button" id="hide-edit-modal-btn" data-modal-hide="edit-modal" class="min-w-[101px] p-2 border border-primary rounded-full text-sm text-primary">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ./Edit Modal --}}

    <script>
        function confirmDelete(id) {
            document.getElementById('delete-section-id').value = id
            document.getElementById('open-confirm-delete-modal-btn').click()
        }

        function editSection(id, name) {
            document.getElementById('input-edit-section-id').value = id
            document.getElementById('input-edit-section-name').value = name
            document.getElementById('open-edit-modal-btn').click()
            document.getElementById('input-edit-section-name').focus()
        }

        document.addEventListener('livewire:load', function () {
            document.getElementById('delete-section-btn').addEventListener('click', function () {
                const sectionId = document.getElementById('delete-section-id').value

                @this.call('deleteSection', sectionId)
                    .then(() => {
                        document.getElementById('hide-delete-modal-btn').click()
                    })
            })

            document.getElementById('save-btn').addEventListener('click', function () {
                const sectionName = document.getElementById('input-new-section').value

                if (sectionName.trim() === '') {
                    toastr.error('Please enter group section name')
                } else {
                    @this.call('addSection', sectionName)
                        .then(() => {
                            document.getElementById('input-new-section').value = ''
                            document.getElementById('hide-add-modal-btn').click()
                        })
                }
            })

            document.getElementById('update-btn').addEventListener('click', function () {
                const sectionId = document.getElementById('input-edit-section-id').value
                const sectionName = document.getElementById('input-edit-section-name').value

                if (sectionName.trim() === '') {
                    toastr.error('Please enter group section name')
                } else {
                    @this.call('updateSection', sectionId, sectionName)
                        .then(() => {
                            document.getElementById('input-edit-section-id').value = ''
                            document.getElementById('input-edit-section-name').value = ''
                            document.getElementById('hide-edit-modal-btn').click()
                        })
                }
            })
        })

        document.getElementById('hide-delete-modal-btn').addEventListener('click', () => {
            document.getElementById('delete-section-id').value = ''
        })
    </script>
</div>
