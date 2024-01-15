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

            {{-- Filter - Mentorship Type --}}
            <div class="flex flex-col">
                <h2 class="text-lg text-darker-blue">
                    Mentorship Type
                </h2>

                <select wire:model="filterByMentorshipType" class="mt-4 text-sm border border-primary rounded-md">
                    <option value="" hidden>
                        Select Mentorship Type
                    </option>
                    <option value="skills_track">
                        Skills
                    </option>
                    <option value="entrepreneur_track">
                        Entrepreneur
                    </option>
                </select>

                <button
                    type="button"
                    wire:click="$set('filterByMentorshipType', '')"
                    class="{{ empty($filterByMentorshipType) ? 'hidden' : 'block' }} self-end mt-2 mr-1 text-sm hover:underline"
                >
                    Reset
                </button>
            </div>
            {{-- ./Filter - Mentorship Type --}}

            {{-- Filter - Country --}}
            <div class="flex flex-col">
                <h2 class="text-lg text-darker-blue">
                    Country
                </h2>

                <select wire:model="filterByCountry" class="mt-4 text-sm border border-primary rounded-md">
                    <option value="" hidden>
                        Select Country
                    </option>

                    @foreach ($countries as $country)
                        <option value="{{ $country->name }}">
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>

                <button
                    type="button"
                    wire:click="$set('filterByCountry', '')"
                    class="{{ empty($filterByCountry) ? 'hidden' : 'block' }} self-end mt-2 mr-1 text-sm hover:underline"
                >
                    Reset
                </button>
            </div>
            {{-- ./Filter - Country --}}
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
                        <th scope="col" class="pl-5 pr-8">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-center text-darker-blue font-medium">
                                    Full Name
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="pr-8">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-center text-darker-blue font-medium">
                                    Mentor
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="pr-8">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-center text-darker-blue font-medium">
                                    Staff
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="pr-8">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-center text-darker-blue font-medium">
                                    Country
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="pr-8">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-center text-darker-blue font-medium">
                                    Team Name
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="pr-8">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-center text-darker-blue font-medium">
                                    Mentorship Type
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
                    @foreach ($participants as $participant)
                        <tr x-data="{
                            expanded: false,

                            toggleExpanded() {
                                this.expanded = !this.expanded;

                                if (this.expanded) {
                                    document.getElementById('participant-detail-{{ $participant->id }}').removeAttribute('hidden');
                                } else {
                                    document.getElementById('participant-detail-{{ $participant->id }}').setAttribute('hidden', 'hidden');
                                }
                            }
                        }" class="{{ $loop->iteration % 2 === 0 ? 'bg-[#EBEDFF]' : 'bg-[#F8F8F8]' }}">
                            <td x-bind:class="expanded ? 'rounded-tl-lg' : 'rounded-s-lg'" class="pr-8 pl-5 py-2">
                                {{ $participant->first_name ?? '-' }} {{ $participant->last_name ?? '' }}
                            </td>

                            <td class="pr-8 py-2">
                                {{ $participant->mentor->first_name ?? '-' }} {{ $participant->mentor->last_name ?? '' }}
                            </td>

                            <td class="pr-8 py-2">
                                {{ $participant->staff->first_name ?? '-' }} {{ $participant->staff->last_name ?? '' }}
                            </td>

                            <td class="pr-8 py-2">
                                {{ $participant->country ?? '-' }}
                            </td>

                            <td class="pr-8 py-2">
                                {{ $participant->team_name ?? '-' }}
                            </td>

                            <td class="pr-8 py-2">
                                {{ $participant->getMentorshipTrack() }}
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

                        {{-- Participant Details --}}
                        <tr hidden id="participant-detail-{{ $participant->id }}" class="{{ $loop->iteration % 2 === 0 ? 'bg-[#EBEDFF]' : 'bg-[#F8F8F8]' }} relative -top-4">
                            <td colspan="7" class="px-5 py-6 rounded-b-lg">
                                <div class="grid grid-cols-4 gap-4">
                                    {{-- DOB --}}
                                    <div class="col-span-1 flex gap-x-4 gap-y-1">
                                        <p class="text-sm text-darker-blue font-medium">
                                            Date of Birth:
                                        </p>

                                        <p class="text-sm">
                                            {{ $participant->date_of_birth ? date('d/m/Y', strtotime($participant->date_of_birth)) : '-' }}
                                        </p>
                                    </div>
                                    {{-- ./DOB --}}

                                    {{-- Sex --}}
                                    <div class="col-span-1 flex gap-x-4 gap-y-1">
                                        <p class="text-sm text-darker-blue font-medium">
                                            Sex:
                                        </p>

                                        <p class="text-sm">
                                            {{ $participant->sex ? ucfirst($participant->sex) : '-' }}
                                        </p>
                                    </div>
                                    {{-- ./Sex --}}

                                    {{-- City --}}
                                    <div class="col-span-1 flex gap-x-4 gap-y-1">
                                        <p class="text-sm text-darker-blue font-medium">
                                            City:
                                        </p>

                                        <p class="text-sm">
                                            {{ $participant->state ?? '-' }}
                                        </p>
                                    </div>
                                    {{-- ./City --}}

                                    {{-- Institution --}}
                                    <div class="col-span-1 flex flex-wrap gap-x-4 gap-y-1">
                                        <p class="text-sm text-darker-blue font-medium">
                                            Educational Institution:
                                        </p>

                                        <p class="text-sm">
                                            @if ($participant->institution_name)
                                                {{ $participant->institution_name }}
                                            @elseif ($participant->institution)
                                                {{ $participant->institution->name }}
                                            @endif
                                        </p>
                                    </div>
                                    {{-- ./Institution --}}

                                    {{-- Study Program --}}
                                    <div class="col-span-2 flex flex-wrap gap-x-4 gap-y-1">
                                        <p class="text-sm text-darker-blue font-medium">
                                            Study Program:
                                        </p>

                                        <p class="text-sm">
                                            {{ $participant->study_program ?? '-' }}
                                        </p>
                                    </div>
                                    {{-- ./Study Program --}}

                                    {{-- Year of Study --}}
                                    <div class="col-span-2 flex flex-wrap gap-x-4 gap-y-1">
                                        <p class="text-sm text-darker-blue font-medium">
                                            Year of Study:
                                        </p>

                                        <p class="text-sm">
                                            {{ $participant->year_of_study ?? '-' }}
                                        </p>
                                    </div>
                                    {{-- ./Year of Study --}}

                                    {{-- Email --}}
                                    <div class="col-span-4 flex flex-wrap gap-x-4 gap-y-1">
                                        <p class="text-sm text-darker-blue font-medium">
                                            Email:
                                        </p>

                                        <p class="text-sm">
                                            {{ $participant->email }}
                                        </p>
                                    </div>
                                    {{-- ./Email --}}
                                </div>

                                {{-- Timeline --}}
                                <div class="min-h-[8rem] mt-7 px-2 py-3 bg-white border border-grey rounded-2xl">
                                    <h1 class="text-center text-xs">
                                        Project Timeline
                                    </h1>

                                    <div class="mt-4 flex justify-between">
                                        <p class="text-xs text-center">
                                            {{ $participant->created_at->format('d M Y') }}
                                        </p>

                                        <div class="relative w-full">
                                            <div class="w-full relative ">
                                                {{ $this->getDataFlag($participant) }}
                                                <div class="bg-gray-200 rounded-full h-1.5 mt-4 ">
                                                    <div class="bg-[#11BF61] h-1.5 rounded-full " style="width: {{ $this->getDataDate($participant) }}  %"></div>
                                                </div>
                                                {{ $this->getDataInfo($participant) }}
                                            </div>
                                        </div>

                                        <p class="text-xs text-center">
                                            {{ date_format(new DateTime($participant->end_date), "d-M-Y") }}
                                        </p>
                                    </div>
                                </div>
                                {{-- ./Timeline --}}
                            </td>
                        </tr>
                        {{-- ./Participant Details --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- ./Table --}}

    {{-- Pagination --}}
    <div class="mt-5 px-2 flex items-center">
        <div class="max-w-[50%] ml-auto">
            {{ $participants->links() }}
        </div>
    </div>
    {{-- ./Pagination --}}
</div>
