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
                        @foreach ($this->sortOptions as $key => $value)
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
                        <th scope="col" class="pr-8">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-center text-darker-blue font-medium">
                                    {{ $this->isStaff ? 'Staff' : 'Mentor' }} Name
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="pr-8">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-center text-darker-blue font-medium">
                                    Email
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="pr-8">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-center text-darker-blue font-medium">
                                    Joining Date
                                </span>
                            </div>
                        </th>

                        <th scope="col">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-darker-blue font-medium">
                                    View
                                </span>
                            </div>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($mentors as $mentor)
                        <tr x-data="{
                            expanded: false,

                            toggleExpanded() {
                                this.expanded = !this.expanded;

                                if (this.expanded) {
                                    document.getElementById('{{ $this->pageName }}-detail-{{ $mentor->id }}').removeAttribute('hidden');
                                } else {
                                    document.getElementById('{{ $this->pageName }}-detail-{{ $mentor->id }}').setAttribute('hidden', 'hidden');
                                }
                            }
                        }" class="{{ $loop->iteration % 2 === 0 ? 'bg-[#EBEDFF]' : 'bg-[#F8F8F8]' }}">
                            <td x-bind:class="expanded ? 'rounded-tl-lg' : 'rounded-s-lg'" class="pr-8 pl-5 py-2">
                                @if (!$mentor->first_name && !$mentor->last_name)
                                    <span class="italic text-gray-400 text-xs">
                                        Registration is not completed yet
                                    </span>
                                @else
                                    {{ $mentor->first_name }} {{ $mentor->last_name }}
                                @endif
                            </td>

                            <td class="pr-8 py-2">
                                {{ $mentor->email }}
                            </td>

                            <td class="pr-8 py-2">
                                {{ $mentor->created_at->format('d/m/Y') }}
                            </td>

                            <template x-if="expanded == false">
                                <td class="pr-5 py-2 rounded-e-lg">
                                    <button x-on:click="toggleExpanded()" type="button" class="w-full text-center text-light-blue">
                                        <i class="fas fa-chevron-down fa-sm"></i>
                                    </button>
                                </td>
                            </template>

                            <template x-if="expanded == true">
                                <td class="pr-5 py-2 rounded-tr-lg">
                                    <button x-on:click="toggleExpanded()" type="button" class="w-full text-center text-light-blue">
                                        <i class="fas fa-chevron-up fa-sm"></i>
                                    </button>
                                </td>
                            </template>
                        </tr>

                        {{-- Mentor Details --}}
                        <tr hidden id="{{ $this->pageName }}-detail-{{ $mentor->id }}" class="{{ $loop->iteration % 2 === 0 ? 'bg-[#EBEDFF]' : 'bg-[#F8F8F8]' }} relative -top-4">
                            <td colspan="4" class="px-5 py-6 rounded-b-lg">
                                <div class="flex justify-between items-center">
                                    <p class="text-darker-blue font-medium">
                                        Total Participants:
                                        <span class="text-black">
                                            {{ $this->isStaff ? $mentor->staffStudents->count() : $mentor->mentorStudents->count() }}
                                        </span>
                                    </p>

                                    <a href="{{ route('dashboard.staffs.participants', ['staff' => $mentor->id]) }}" class="w-max px-8 py-1 bg-[#6973C6] rounded-full flex justify-center items-center gap-3 text-white">
                                        List of Participants
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>

                                    <a href="{{ route('dashboard.staffs.edit', ['staff' => $mentor->id]) }}" class="w-max px-8 py-1 bg-darker-blue rounded-full flex justify-center items-center gap-3 text-white">
                                        Edit Details
                                    </a>

                                    <form action="{{ route('dashboard.staffs.destroy', [$mentor->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            onclick="return confirm('Are you sure you want to delete < {{ $mentor->first_name }} {{ $mentor->last_name }} > account?')"
                                            class="w-max px-8 py-1 bg-dark-red rounded-full flex justify-center items-center gap-3 text-white">
                                            Delete Account
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        {{-- ./Mentor Details --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- ./Table --}}

    {{-- Pagination --}}
    <div class="mt-5 px-2 flex items-center">
        <div class="max-w-[50%] ml-auto">
            {{ $mentors->links() }}
        </div>
    </div>
    {{-- ./Pagination --}}
</div>
