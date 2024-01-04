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

            {{-- Filter - Project --}}
            {{-- <div class="flex flex-col">
                <h2 class="text-lg text-darker-blue">
                    Project
                </h2>

                <select wire:model="filterByProject" class="mt-4 text-sm border border-primary rounded-md">
                    <option value="" hidden>
                        Select Project
                    </option>

                    @foreach ($this->projectOptions as $key => $value)
                        <option value="{{ $key }}">
                            {{ $value }}
                        </option>
                    @endforeach
                </select>

                <button
                    type="button"
                    wire:click="$set('filterByProject', '')"
                    class="{{ empty($filterByProject) ? 'hidden' : 'block' }} self-end mt-2 mr-1 text-sm hover:underline"
                >
                    Reset
                </button>
            </div> --}}
            {{-- ./Filter - Project --}}

            {{-- Filter - Project Domain --}}
            <div class="flex flex-col">
                <h2 class="text-lg text-darker-blue">
                    Project Domain
                </h2>

                <select wire:model="filterByProjectDomain" class="mt-4 text-sm border border-primary rounded-md">
                    <option value="" hidden>
                        Select Project Domain
                    </option>

                    @foreach ($this->projectDomainOptions as $key => $value)
                        <option value="{{ $key }}">
                            {{ $value }}
                        </option>
                    @endforeach
                </select>

                <button
                    type="button"
                    wire:click="$set('filterByProjectDomain', '')"
                    class="{{ empty($filterByProjectDomain) ? 'hidden' : 'block' }} self-end mt-2 mr-1 text-sm hover:underline"
                >
                    Reset
                </button>
            </div>
            {{-- ./Filter - Project Domain --}}
        </div>

        <button wire:click="resetAllFilters" type="button" class="mt-8 px-8 py-2 text-sm text-white bg-primary rounded-full">
            Reset All Filters
        </button>
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
                                    Project Name
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="pr-8">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-darker-blue font-medium">
                                    Project Domain
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="pr-8">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-darker-blue font-medium">
                                    Task Name
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="pr-5">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-darker-blue font-medium">
                                    Messages
                                </span>
                            </div>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($projectSections as $projectSection)
                        <tr class="{{ $loop->iteration % 2 === 0 ? 'bg-[#EBEDFF]' : 'bg-[#F8F8F8]' }}">
                            <td class="pr-8 pl-5 py-2 rounded-s-lg">
                                {{ $projectSection->project->name }}
                            </td>

                            <td class="pr-8 py-2">
                                {{ $projectSection->project->getProjectDomainText() }}
                            </td>

                            <td class="pr-8 py-2">
                                {{ substr($projectSection->title, 0, 35) }} {{ strlen($projectSection->title) >= 35 ? '...' : '' }}
                            </td>

                            <td class="pr-5 py-2 rounded-e-lg">
                                <a href="{{ route('dashboard.messages.taskMessage', ['injection' => $projectSection->id]) }}" class="px-3 py-1 bg-primary rounded-lg flex justify-between items-center gap-3 text-white text-sm">
                                    <span class="flex items-center">
                                        Messages

                                        @if (commentPerSection($projectSection)->count() > 0)
                                            <span class="bg-[#EA0202] p-1 rounded-full">
                                                {{ commentPerSection($projectSection)->count() }}
                                            </span>
                                        @endif
                                    </span>

                                    <span>></span>
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
            {{ $projectSections->links() }}
        </div>
    </div>
    {{-- ./Pagination --}}
</div>
