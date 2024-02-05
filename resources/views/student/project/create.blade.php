@extends('layouts.profile.index')

@section('content')
<div class="pt-14 pb-48 px-16 bg-white">
    <div class="py-6 px-11 bg-[#fafafa] border border-grey rounded-xl">
        {{-- Page Title --}}
        <h1 class="font-medium text-darker-blue text-[1.35rem]">
            <a href="{{ route('student.allProjects', ['student' => auth()->user()->id]) }}" class="hover:underline">
                My Project
            </a>
            <span class="ml-2 mr-4">></span>
            Add Project
        </h1>

        <div class="w-full tab:w-[941px] mt-7 mx-auto flex flex-col items-center">
            {{-- Project Name --}}
            <input
                type="text"
                placeholder="Project Name *"
                name="project_name"
                class="w-full h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none"
            >

            {{-- Project Domain and Duration --}}
            <div class="w-full mt-5 mb-5 grid grid-cols-7 items-center gap-3">
                <select class="col-span-4 p-2.5 bg-white border border-grey text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block">
                    <option class="hover:bg-lightest-blue">Computer Vision (CV)</option>
                    <option class="hover:bg-lightest-blue">Natural Language Processing (NLP)</option>
                    <option class="hover:bg-lightest-blue">Machine Learning (ML)</option>
                </select>

                <input
                    type="text"
                    value="10 Weeks"
                    class="col-span-3 h-12 px-3 py-2 bg-[#D8D8D8] border border-grey rounded-lg focus:outline-none"
                    disabled
                >
            </div>

            {{-- Intel Corp --}}
            <input
                type="text"
                value="Intel Corp"
                class="mt-5 mb-5 w-full h-12 px-3 py-2 bg-[#D8D8D8] border border-grey rounded-lg focus:outline-none"
                disabled hidden
            >

            {{-- Description --}}
            <textarea name="problem" id="problem"
                rows="10"
                placeholder="- Problem Statement, Project Objective, or Use Case Description&#13;&#10;- Model Type&#13;&#10;- Current Performance Metrics&#13;&#10;- Summary of Future Goals/Expectations"
                class="w-full mt-5 px-3 py-2 border border-grey rounded-lg focus:outline-none"
            ></textarea>

            {{-- Overview --}}
            <input
                type="text"
                placeholder="Write a 2 - 3 sentence description of your project."
                name="description"
                class="mt-5 w-full h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none"
            >

            {{-- Logo --}}
            {{-- <div class="w-full mt-4 flex flex-col gap-2">
                <h2 class="font-medium text-darker-blue text-xl">
                    Logo Project (Optional)
                </h2>

                <div id="input-logo-trigger" class="w-full h-20 bg-white border border-dashed border-grey flex justify-center items-center cursor-pointer">
                    logo_project.jpg
                </div>

                <input type="file" id="input-logo" accept="image/*" hidden>
            </div> --}}

            {{-- Datasets --}}
            <div class="w-full mt-4 flex flex-col gap-2">
                <h2 class="font-medium text-darker-blue text-xl">
                    Add Datasets
                    <span class="text-red-500">*</span>
                </h2>

    <!-- Custom input container -->
    <div id="custom-input-container" class="w-full h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none flex flex-wrap items-center gap-1">
        <!-- Badges will be dynamically inserted here -->
    </div>
    <!-- Hidden real input to store the actual value -->
    <input
        type="hidden"
        name="dataset[]"
        id="hidden-input"
    >
            </div>

            {{-- Task --}}
            <div class="w-full mt-6 flex justify-between items-center">
                <h2 class="font-medium text-darker-blue text-xl">
                    Task
                    <span class="text-red-500">*</span>
                </h2>

                <a href="{{ route('participant.projects.add-task') }}" class="text-darker-blue hover:underline">
                    Add Task
                </a>
            </div>

            {{-- Task List --}}
            <div class="w-full mt-3 flex flex-col gap-2">
                <p id="no-task-info" class="my-2 text-center italic">
                    Please add at least 1 task
                </p>

                <div id="task-list" class="flex-col gap-2" style="display: ">
                    @for ($i = 1; $i <= 2; $i++)
                        <div class="w-full h-16 pl-6 pr-4 mt-4 bg-white border border-grey rounded-lg grid grid-cols-12 items-center gap-1">
                            <p class="col-span-8 text-sm">
                                Task {{ $i }}:-
                            </p>

                            {{-- <div class="col-span-2 text-xs">
                                <p>Assigned to:</p>
                                <p>-</p>
                            </div> --}}

                            {{-- <div class="col-span-2 text-xs">
                                <p>Duration:</p>
                                <p>10 Weeks</p>
                            </div> --}}

                            <div class="col-span-2 text-xs">
                                <p>Due Date:</p>
                                <p>-/-/-</p>
                            </div>

                            <div class="col-span-2 flex items-center gap-6 ml-auto">
                                <button class="text-darker-blue">
                                    <i class="fas fa-pen"></i>
                                </button>

                                <button class="text-red-500">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-center">
        <button type="button" id="add-project-btn" class="min-w-[196px] py-2 px-3 bg-[#E9E9E9] border border-grey rounded-full text-[#838383] text-lg">
            Add Project
        </button>
    </div>
</div>
@endsection

@section('more-js')
    <script>
        $('#input-logo-trigger').on('click', function() {
            $('#input-logo').click()
        })

        $('#add-project-btn').on('click', function() {
            if ($(this).hasClass('bg-[#E9E9E9]')) {
                $('#no-task-info').css('display', 'none')
                $('#task-list').css('display', 'flex')
                $(this).removeClass('bg-[#E9E9E9] border-grey text-[#838383]').addClass('bg-primary border-primary text-white')
            } else {
                $('#no-task-info').css('display', 'block')
                $('#task-list').css('display', 'none')
                $(this).removeClass('bg-primary border-primary text-white').addClass('bg-[#E9E9E9] border-grey text-[#838383]')
            }
        })

        document.addEventListener('DOMContentLoaded', function() {
    // Load saved values from localStorage
    loadFromLocalStorage();
});

document.addEventListener('DOMContentLoaded', function() {
    // Load saved values from localStorage
    loadFromLocalStorage();
});

// Select the input elements
const projectNameInput = document.querySelector('input[name="project_name"]');
const descriptionInput = document.querySelector('input[name="description"]');
const hiddenInput = document.querySelector('#hidden-input');
const customInputContainer = document.querySelector('#custom-input-container');
const selectElement = document.querySelector('select'); // Add this line

// Event listeners to save input values whenever they change
projectNameInput.addEventListener('input', saveProjectNameToLocalStorage);
descriptionInput.addEventListener('input', saveDescriptionToLocalStorage);
selectElement.addEventListener('change', saveSelectValueToLocalStorage); // Add this line

// Load the input values when the page is loaded and update badges
function loadFromLocalStorage() {
    projectNameInput.value = localStorage.getItem('projectName') || '';
    descriptionInput.value = localStorage.getItem('description') || '';
    hiddenInput.value = localStorage.getItem('cloudLinks') || '';
    const savedSelectValue = localStorage.getItem('selectValue');
    // Remove the placeholder if it exists
    const placeholderOption = selectElement.querySelector('option[value=""]');
    if (placeholderOption) {
        selectElement.removeChild(placeholderOption);
    }

    if (savedSelectValue) {
        selectElement.value = savedSelectValue;
    } else {
        // Add a placeholder option and select it if there is no saved value
        const defaultOption = new Option("Select Project Domain", "", false, false);
        defaultOption.disabled = true;
        defaultOption.hidden = true; // Hide the option so it doesn't show in the dropdown
        selectElement.prepend(defaultOption);
        selectElement.value = "";
    }
    updateBadges();
}

// Function to save data to localStorage
function saveProjectNameToLocalStorage() {
    localStorage.setItem('projectName', projectNameInput.value);
}

function saveDescriptionToLocalStorage() {
    localStorage.setItem('description', descriptionInput.value);
}

function saveCloudLinksToLocalStorage() {
    localStorage.setItem('cloudLinks', hiddenInput.value);
}

function saveSelectValueToLocalStorage() { // Add this function
    localStorage.setItem('selectValue', selectElement.value);
}

// Function to update badges
function updateBadges() {
    customInputContainer.innerHTML = ''; // Clear the container
    const linksArray = hiddenInput.value.split(';').filter(Boolean);
    linksArray.forEach((link, index) => createBadge(link, index + 1));
}

// Function to create a badge for a link
function createBadge(link, index) {
    const badge = document.createElement('span');
    badge.className = 'inline-flex items-center px-2 py-1 me-2 text-sm font-medium text-green-800 bg-green-100 rounded dark:bg-green-900 dark:text-green-300';
    badge.textContent = `Dataset ${ordinal(index)}`;
    const removeBtn = document.createElement('button');
    removeBtn.innerHTML = `<svg class="w-2 h-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>`;
    removeBtn.className = 'inline-flex items-center p-1 ms-2 text-sm text-green-400 bg-transparent rounded-sm hover:bg-green-200 hover:text-green-900 dark:hover:bg-green-800 dark:hover:text-green-300';
    removeBtn.onclick = (event) => {
        event.stopPropagation();
        removeBadge(index - 1);
    };
    badge.appendChild(removeBtn);
    customInputContainer.appendChild(badge);
    badge.onclick = () => editBadge(index - 1);
}

// Function to edit a badge
function editBadge(index) {
    const linksArray = hiddenInput.value.split(';').filter(Boolean);
    const newLink = prompt('Edit your link:', linksArray[index]);
    if (newLink !== null && newLink !== '') {
        linksArray[index] = newLink;
        hiddenInput.value = linksArray.join(';');
        updateBadges();
        saveCloudLinksToLocalStorage();
    }
}

// Function to remove a badge and its link
function removeBadge(index) {
    const linksArray = hiddenInput.value.split(';').filter(Boolean);
    linksArray.splice(index, 1);
    hiddenInput.value = linksArray.join(';');
    updateBadges();
    saveCloudLinksToLocalStorage();
}

// Function to convert number to ordinal
function ordinal(n) {
    const s = ["th", "st", "nd", "rd"],
          v = n % 100;
    return n + (s[(v - 20) % 10] || s[v] || s[0]);
}

// Add click event listener to the custom input container to add new links
customInputContainer.addEventListener('click', function(event) {
    if (event.target === customInputContainer) {
        const newLink = prompt('Add new link:');
        if (newLink) {
            const linksArray = hiddenInput.value.split(';').filter(Boolean);
            linksArray.push(newLink);
            hiddenInput.value = linksArray.join(';');
            updateBadges();
            saveCloudLinksToLocalStorage();
        }
    }
});
    </script>
@endsection
