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

        <div class="w-full tab:w-[941px] mt-7 mx-auto flex flex-col">
            {{-- Project Name --}}
            <h2 class="font-medium text-darker-blue text-xl mb-2">
                Project Name
                <span class="text-red-500">*</span>
            </h2>
            <input
                type="text"
                placeholder="Project Name"
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

            <h2 class="font-medium text-darker-blue text-xl mb-2">
                Project Details
                <span class="text-red-500">*</span>
            </h2>
            {{-- Description --}}
            <textarea name="sharedproject" id="sharedproject"
                rows="10"
                class="w-full mt-5 px-3 py-2 border border-grey rounded-lg focus:outline-none"
            ></textarea>

            <h2 class="font-medium text-darker-blue text-xl mt-5">
                Project Descriptions
                <span class="text-red-500">(Optional)</span>
            </h2>
            {{-- Overview --}}
            <input
                type="text"
                placeholder="Write a 2 - 3 sentence description of your project."
                name="description"
                class="mt-2 w-full h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none"
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
                    Add Dataset(s)
                    <span class="text-red-500">*</span>
                    <i data-tooltip-target="tooltip-animation" class="fa fa-info-circle" aria-hidden="true"></i>

                    <div id="tooltip-animation" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Tooltip content
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
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

                {{-- <a href="{{ route('participant.projects.add-task') }}" class="text-darker-blue hover:underline">
                    Add Task
                </a> --}}
                <a href="#" id="add-task-button" class="text-darker-blue hover:underline">
                    Add Task
                </a>
            </div>

            {{-- Task List --}}
            <div class="w-full mt-3 flex flex-col gap-2">
                <p id="no-task-info" class="my-2 text-center italic">
                    Please add at least 1 task
                </p>

                <div id="task-list" class="flex-col gap-2" style="display: ">

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
    // Load saved tasks from localStorage
    loadTasksFromLocalStorage();

    // Add task event listener
    document.getElementById('add-task-button').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior
        addTask();
    });

    // Load saved values from localStorage for other inputs
    loadFromLocalStorage();
});

// Function to load tasks from localStorage
function loadTasksFromLocalStorage() {
    const tasksJson = localStorage.getItem('tasks');
    const tasks = tasksJson ? JSON.parse(tasksJson) : [];
    tasks.forEach(task => {
        addTaskToDOM(task);
    });
    updateNoTaskInfoDisplay();
}

function getTasksFromLocalStorage() {
    // Attempt to retrieve the existing tasks from local storage and parse them
    const storedTasks = localStorage.getItem('tasks');
    try {
        return storedTasks ? JSON.parse(storedTasks) : [];
    } catch (error) {
        // In case of any errors during parsing, return an empty array
        console.error('Error parsing tasks from local storage:', error);
        return [];
    }
}

function saveTaskToLocalStorage(newTask) {
    // Retrieve existing tasks from local storage
    const tasks = getTasksFromLocalStorage();

    // Add the new task to the array of tasks
    tasks.push(newTask);

    // Save the updated tasks array back to local storage
    localStorage.setItem('tasks', JSON.stringify(tasks));
}

function addTask() {
    // Calculate the new task's index based on the existing tasks in local storage
    const tasks = getTasksFromLocalStorage();
    const total = tasks.length + 1;

    const newTask = {
        TaskName: `Task ${total}`,
        DueDate: "-/-/-", // Placeholder value
        TaskAttachments: [
            {
                Name: "Attachment Name", // Placeholder value
                Link: "Attachment Link"  // Placeholder value
            }
        ]
    };

    // Add the new task to the DOM (Implementation of addTaskToDOM is assumed to be correct)
    addTaskToDOM(newTask);

    // Save the new task to local storage
    saveTaskToLocalStorage(newTask);

    // Redirect to the "Edit Task" page with the index of the new task
    // Note: Since we're redirecting immediately after adding, the taskIndex for redirect should be tasks.length, as it's the index of the new task before it's added
    window.location.href = `https://mentorship-platform.dev/participant/projects/edit-task/${tasks.length}`;
}


// Function to add a task to the DOM
function addTaskToDOM(task) {
    const taskList = document.getElementById('task-list');
    // Count the current number of tasks in the DOM to determine the new task's number
    // Adding 1 because we're about to add a new task
    const taskNumber = taskList.children.length + 1;
    const newTaskElement = document.createElement('div');
    newTaskElement.className = 'w-full h-16 pl-6 pr-4 mt-4 bg-white border border-grey rounded-lg grid grid-cols-12 items-center gap-1';
    newTaskElement.innerHTML = `
        <p class="col-span-8 text-sm">
            Task ${taskNumber} : ${task.TaskName}
        </p>
        <div class="col-span-2 text-xs">
            <p>Due Date:</p>
            <p class="due-date">${task.DueDate}</p>
        </div>
        <div class="col-span-2 flex items-center gap-6 ml-auto">
            <button class="text-darker-blue" onclick="editTask(this)">
                <i class="fas fa-pen"></i>
            </button>
            <button class="text-red-500" onclick="removeTask(this)">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    `;
    taskList.appendChild(newTaskElement);
}

// Function to edit a task
function editTask(button) {
    const taskElement = button.closest('.w-full.h-16.pl-6.pr-4.mt-4.bg-white.border.border-grey.rounded-lg.grid.grid-cols-12.items-center.gap-1');
    const taskIndex = Array.from(taskElement.parentNode.children).indexOf(taskElement);
    const tasks = JSON.parse(localStorage.getItem('tasks') || '[]');
    if (tasks.length > taskIndex) {
        // Assuming you have a route named 'participant.projects.edit-task' that accepts a task index
        const editTaskUrl = `/participant/projects/edit-task/${taskIndex}`;
        window.location.href = editTaskUrl; // Redirect to the edit task page
    }
}

// Function to remove a task
function removeTask(button) {
    const taskElement = button.closest('.w-full.h-16.pl-6.pr-4.mt-4.bg-white.border.border-grey.rounded-lg.grid.grid-cols-12.items-center.gap-1');
    const taskIndex = Array.from(taskElement.parentNode.children).indexOf(taskElement);
    const tasks = JSON.parse(localStorage.getItem('tasks') || '[]');
    tasks.splice(taskIndex, 1);
    localStorage.setItem('tasks', JSON.stringify(tasks));
    taskElement.remove();
    updateNoTaskInfoDisplay();
}

// Function to update the display of the no-task-info message
function updateNoTaskInfoDisplay() {
    const noTaskInfo = document.getElementById('no-task-info');
    const taskList = document.getElementById('task-list');
    if (taskList.children.length === 0) {
        noTaskInfo.style.display = 'block';
    } else {
        noTaskInfo.style.display = 'none';
    }
}

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
    // Parse the JSON string back into an array
    const savedLinks = JSON.parse(localStorage.getItem('cloudLinks') || '[]');
    hiddenInput.value = savedLinks.join(';'); // Join the array back into a string for the hidden input
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
    // localStorage.setItem('cloudLinks', hiddenInput.value);
    // Split the input value by ";" and trim each link
    const linksArray = hiddenInput.value.split(';').map(link => link.trim()).filter(link => link !== '');
    // Save the array as a JSON string in localStorage
    localStorage.setItem('cloudLinks', JSON.stringify(linksArray));
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
    // badge.textContent = `Dataset ${ordinal(index)}`;
    badge.textContent = `Dataset ${index}`;
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

tinymce.init({
    // Your other TinyMCE init options...
    init_instance_callback: function(editor) {
        var content = localStorage.getItem('tinyMCEContent');
        if (content) {
            editor.setContent(content);
        }
    }
});

    </script>
@endsection
