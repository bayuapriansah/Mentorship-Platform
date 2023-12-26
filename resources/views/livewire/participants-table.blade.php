<div x-data="{
    showFilters: false,
    checkAllParticipants: false,
    checkedParticipants: [],

    toggleCheckParticipant(id) {
        const participantIndex = this.checkedParticipants.indexOf(id);

        if (participantIndex == -1) {
            this.checkedParticipants.push(id);
        } else {
            this.checkedParticipants.splice(participantIndex, 1);
        }
    },

    toggleCheckAllParticipants() {
        this.checkAllParticipants = !this.checkAllParticipants;

        if (!this.checkAllParticipants) {
            this.checkedParticipants = [];

            document.querySelectorAll('.check-participant').forEach(element => {
                element.checked = false;
            });
        } else {
            document.querySelectorAll('.check-participant').forEach(element => {
                element.checked = true;
                this.checkedParticipants.push(element.value);
            });
        }
    }
}">
    {{-- Search and Filters --}}
    <div class="mt-14 flex justify-end gap-14">
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
                        <option value="created_at">
                            Data Input Time
                        </option>
                        <option value="first_name">
                            Name
                        </option>
                        <option value="team_name">
                            Team Name
                        </option>
                        <option value="country">
                            Country
                        </option>
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
                        <th scope="col" class="pr-8 pl-5">
                            <input
                                x-on:click="toggleCheckAllParticipants()"
                                type="checkbox"
                                class="border border-light-blue rounded-sm cursor-pointer focus:ring-0 checked:bg-light-blue"
                            >
                        </th>

                        <th scope="col" class="pr-8">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-center text-darker-blue font-medium">
                                    Full Name
                                </span>

                                {{-- <div class="flex flex-col gap-4 text-light-blue">
                                    <i class="fas fa-chevron-up fa-sm"></i>
                                    <i class="fas fa-chevron-down fa-sm"></i>
                                </div> --}}
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
                                this.$nextTick(() => {
                                    if (this.expanded) {
                                        document.getElementById('participant-detail-{{ $participant->id }}').removeAttribute('hidden');
                                    } else {
                                        document.getElementById('participant-detail-{{ $participant->id }}').setAttribute('hidden', 'hidden');
                                    }
                                });
                            }
                        }" class="{{ $loop->iteration % 2 === 0 ? 'bg-[#EBEDFF]' : 'bg-[#F8F8F8]' }}">
                            <th scope="row" x-bind:class="expanded ? 'rounded-tl-lg' : 'rounded-s-lg'" class="pr-8 pl-5 py-2">
                                <input
                                    type="checkbox"
                                    value="{{ $participant->id }}"
                                    x-on:click="toggleCheckParticipant({{ $participant->id }})"
                                    class="check-participant border border-light-blue rounded-sm cursor-pointer focus:ring-0 checked:bg-light-blue"
                                >
                            </th>

                            <td class="pr-8 py-2">
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

                            <template x-if="!expanded">
                                <td class="pr-5 py-2 rounded-e-lg">
                                    <button x-on:click="toggleExpanded()" type="button" class="w-full text-center text-light-blue">
                                        <i class="fas fa-chevron-down fa-sm"></i>
                                    </button>
                                </td>
                            </template>

                            <template x-if="expanded">
                                <td class="pr-5 py-2 rounded-tr-lg">
                                    <button x-on:click="toggleExpanded()" type="button" class="w-full text-center text-light-blue">
                                        <i class="fas fa-chevron-up fa-sm"></i>
                                    </button>
                                </td>
                            </template>
                        </tr>

                        {{-- Participant Details --}}
                        <tr hidden id="participant-detail-{{ $participant->id }}" class="{{ $loop->iteration % 2 === 0 ? 'bg-[#EBEDFF]' : 'bg-[#F8F8F8]' }} relative -top-4">
                            <td class="rounded-bl-lg"></td>
                            <td colspan="7" class="pr-5 py-6 rounded-br-lg">
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

                                {{-- Actions --}}
                                <div class="mt-4 flex gap-4">
                                    <a href="{{ url('/dashboard/students/'. $participant->id .'/manage') }}" class="min-w-[126px] min-h-[26px] p-2 bg-dark-blue rounded-lg text-center text-xs text-white">
                                        Edit Details
                                    </a>

                                    <button
                                        type="button"
                                        data-modal-target="confirm-suspend-modal"
                                        data-modal-toggle="confirm-suspend-modal"
                                        data-suspend-id="{{ $participant->id }}"
                                        data-suspend-institution="{{ $participant->institution->id }}"
                                        class="suspend-btn min-w-[126px] min-h-[26px] p-2 bg-dark-yellow rounded-lg text-xs text-white"
                                    >
                                        Suspend Account
                                    </button>

                                    <button
                                        type="button"
                                        data-modal-target="confirm-delete-modal"
                                        data-modal-toggle="confirm-delete-modal"
                                        data-delete-id="{{ $participant->id }}"
                                        data-delete-name="{{ $participant->first_name . ' ' . $participant->last_name }}"
                                        class="delete-btn min-w-[126px] min-h-[26px] p-2 bg-dark-red rounded-lg text-xs text-white"
                                    >
                                        Delete Account
                                    </button>
                                </div>
                                {{-- ./Actions --}}
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
    <div class="mt-5 flex items-center">
        <div x-cloak x-show="checkedParticipants.length == 0">
            <button disabled type="button" data-modal-target="assign-mentor-modal" data-modal-toggle="assign-mentor-modal" class="px-11 py-2 bg-[#C7C7C7] rounded-xl text-white">
                Assign Mentor
            </button>

            <button disabled type="button" data-modal-target="assign-staff-modal" data-modal-toggle="assign-staff-modal" class="ml-4 px-11 py-2 bg-[#C7C7C7] rounded-xl text-white">
                Assign Staff
            </button>
        </div>

        <div x-cloak x-show="checkedParticipants.length > 0">
            <button type="button" data-modal-target="assign-mentor-modal" data-modal-toggle="assign-mentor-modal" class="px-11 py-2 bg-primary rounded-xl text-white">
                Assign Mentor
            </button>

            <button type="button" data-modal-target="assign-staff-modal" data-modal-toggle="assign-staff-modal" class="ml-4 px-11 py-2 bg-primary rounded-xl text-white">
                Assign Staff
            </button>
        </div>

        {{ $participants->links() }}
    </div>
    {{-- ./Pagination --}}

    {{-- Assign Mentor Modal --}}
    <div wire:ignore id="assign-mentor-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white border-2 border-grey rounded-xl">
                <!-- Modal body -->
                <div class="px-9 pt-6 pb-10">
                    <h1 class="text-[1.375rem] text-dark-blue font-medium">
                        Assign Mentor
                    </h1>

                    <p class="mt-4">
                        Assign mentor to the selected participants
                    </p>

                    <div class="max-h-[50vh] mt-6 px-4 overflow-y-auto flex flex-col gap-6">
                        @foreach ($this->mentors as $mentor)
                            <div class="flex items-center gap-4">
                                <input type="radio" id="select-mentor-{{ $mentor->id }}" name="select_mentor" value="{{ $mentor->id }}" class="focus:ring-[#FF8F51] checked:bg-[#FF8F51]">

                                <label for="select-mentor-{{ $mentor->id }}" class="cursor-pointer">
                                    {{ $mentor->first_name }} {{ $mentor->last_name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-7 flex justify-center items-center gap-6">
                        <button id="assign-mentor-btn" class="min-w-[177px] px-11 py-2 bg-primary rounded-full text-white">
                            Assign Mentor
                        </button>

                        <button id="close-assign-mentor-modal-btn" type="button" data-modal-hide="assign-mentor-modal" class="min-w-[177px] px-11 py-2 border border-primary rounded-full text-primary">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ./Assign Mentor Modal --}}

    {{-- Assign Staff Modal --}}
    <div wire:ignore id="assign-staff-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white border-2 border-grey rounded-xl">
                <!-- Modal body -->
                <div class="px-9 pt-6 pb-10">
                    <h1 class="text-[1.375rem] text-dark-blue font-medium">
                        Assign Staff
                    </h1>

                    <p class="mt-4">
                        Assign staff to the selected participants
                    </p>

                    <div class="max-h-[50vh] mt-6 px-4 overflow-y-auto flex flex-col gap-6">
                        @foreach ($this->staffs as $staff)
                            <div class="flex items-center gap-4">
                                <input type="radio" id="select-staff-{{ $staff->id }}" name="select_staff" value="{{ $staff->id }}" class="focus:ring-[#FF8F51] checked:bg-[#FF8F51]">

                                <label for="select-staff-{{ $staff->id }}" class="cursor-pointer">
                                    {{ $staff->first_name }} {{ $staff->last_name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-7 flex justify-center items-center gap-6">
                        <button id="assign-staff-btn" class="min-w-[177px] px-11 py-2 bg-primary rounded-full text-white">
                            Assign Staff
                        </button>

                        <button id="close-assign-staff-modal-btn" type="button" data-modal-hide="assign-staff-modal" class="min-w-[177px] px-11 py-2 border border-primary rounded-full text-primary">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ./Assign Staff Modal --}}

    {{-- Confirm Suspend Modal --}}
    <div wire:ignore id="confirm-suspend-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white border-2 border-grey rounded-xl">
                <div
                    class="absolute top-0 right-0 w-[110px] h-[110px]"
                    style="background: url({{ asset('/assets/img/dots-2.png') }}), transparent -0.072px -7.605px / 181.04% 106.977% no-repeat;"
                ></div>

                <!-- Modal body -->
                <form id="suspend-form" method="POST" class="px-24 pt-12 pb-14">
                    @csrf

                    <input id="suspend-institution" type="hidden" name="institution">

                    <p class="text-center text-[1.375rem] text-darker-blue font-medium">
                        Are you sure you want suspend this account?
                    </p>

                    <div class="mt-7 flex justify-center items-center gap-6">
                        <button type="submit" class="min-w-[101px] p-2 bg-primary rounded-full text-sm text-white">
                            Yes
                        </button>

                        <button type="button" data-modal-hide="confirm-suspend-modal" class="min-w-[101px] p-2 border border-primary rounded-full text-sm text-primary">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ./Confirm Suspend Modal --}}

    {{-- Confirm Delete Modal --}}
    <div wire:ignore id="confirm-delete-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white border-2 border-grey rounded-xl">
                <div
                    class="absolute top-0 right-0 w-[110px] h-[110px]"
                    style="background: url({{ asset('/assets/img/dots-2.png') }}), transparent -0.072px -7.605px / 181.04% 106.977% no-repeat;"
                ></div>

                <!-- Modal body -->
                <form id="delete-form" method="POST" class="px-24 pt-12 pb-14">
                    @csrf
                    @method('DELETE')

                    <p class="text-center text-[1.375rem] text-darker-blue font-medium">
                        Are you sure you want to delete this account permanently?
                    </p>

                    <p id="delete-participant-name" class="mt-4 text-center text-lg">
                    </p>

                    <div class="mt-7 flex justify-center items-center gap-6">
                        <button type="submit" class="min-w-[101px] p-2 bg-primary rounded-full text-sm text-white">
                            Yes
                        </button>

                        <button type="button" data-modal-hide="confirm-delete-modal" class="min-w-[101px] p-2 border border-primary rounded-full text-sm text-primary">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ./Confirm Delete Modal --}}

    <script>
        document.addEventListener('livewire:load', function () {
            document.querySelectorAll('.suspend-btn').forEach(function (element) {
                element.addEventListener('click', function () {
                    const actionUrl = "{{ url('/dashboard/students/XXX/suspend') }}"
                    const participantId = element.getAttribute('data-suspend-id')
                    const institutionId = element.getAttribute('data-suspend-institution')

                    document.getElementById('suspend-form').setAttribute('action', actionUrl.replace('XXX', participantId))
                    document.getElementById('suspend-institution').setAttribute('value', institutionId)
                })
            })

            document.querySelectorAll('.delete-btn').forEach(function (element) {
                element.addEventListener('click', function () {
                    const actionUrl = "{{ url('/dashboard/students/XXX') }}"
                    const participantId = element.getAttribute('data-delete-id')
                    const participantName = element.getAttribute('data-delete-name')

                    document.getElementById('delete-form').setAttribute('action', actionUrl.replace('XXX', participantId))
                    document.getElementById('delete-participant-name').innerHTML = `You will delete the account "${participantName}"`
                })
            })

            document.getElementById('assign-mentor-btn').addEventListener('click', function () {
                const mentor = document.querySelector('input[name="select_mentor"]:checked')

                if (mentor) {
                    const mentorId = mentor.value
                    let participantIds = []

                    document.querySelectorAll('.check-participant').forEach(function (element) {
                        if (element.checked) {
                            participantIds.push(element.value)
                        }
                    })

                    @this.assignMentor(mentorId, participantIds).then(function () {
                        document.getElementById('close-assign-mentor-modal-btn').click()
                    })
                }
            })

            document.getElementById('assign-staff-btn').addEventListener('click', function () {
                const staff = document.querySelector('input[name="select_staff"]:checked')

                if (staff) {
                    const staffId = staff.value
                    let participantIds = []

                    document.querySelectorAll('.check-participant').forEach(function (element) {
                        if (element.checked) {
                            participantIds.push(element.value)
                        }
                    })

                    @this.assignStaff(staffId, participantIds).then(function () {
                        document.getElementById('close-assign-staff-modal-btn').click()
                    })
                }
            })
        })
    </script>
</div>
