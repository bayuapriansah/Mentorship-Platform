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
            <a href="{{ route('participant.projects.create') }}" class="hover:underline">
                Add Project
            </a>
            <span class="ml-2 mr-4">></span>
            Add Task
        </h1>

        <div class="w-full tab:w-[641px] mt-7 mx-auto flex flex-col items-center">
            {{-- Task Name --}}
            <input
                type="text"
                placeholder="Task Name *"
                name="TaskName"
                class="w-full h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none"
            >

            {{-- Due Date --}}
            <div class="w-full mt-6 flex flex-col gap-3">
                <h2 class="font-medium text-darker-blue text-xl">
                    Due Date:
                </h2>

                <input
                    type="date"
                    name="DueDate"
                    class="h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none"
                >
            </div>

            {{-- Details --}}
            <textarea
                rows="10"
                placeholder="Task Details *"
                name="TaskDetail"
                class="w-full mt-7 px-3 py-2 border border-grey rounded-lg focus:outline-none"
            ></textarea>

            {{-- Attachment --}}
            <div class="w-full mt-9">
                <h2 class="font-medium text-darker-blue text-xl">
                    Task Attachments
                    <span class="text-red-500">*</span>
                </h2>

                <div id="attachments-container" class="mt-3 flex flex-col gap-4">
                    <div class="flex justify-between items-center">
                        <input
                            type="text"
                            value=""
                            placeholder="Document Name *"
                            name="Name"
                            class="w-[290px] h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none"
                        >

                        <input
                            type="text"
                            value=""
                            placeholder="Document URL *"
                            name="Link"
                            class="w-[290px] h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none"
                        >

                        <!-- Change the id to class -->
                        <button class="add-attachment-btn w-6 h-6 bg-primary text-white rounded-full">
                            <i class="fas fa-plus"></i>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-center">
        <button type="button" id="save-task-btn" class="min-w-[196px] py-2 px-3 bg-primary border border-primary rounded-full text-white text-lg">
            Save Task
        </button>
    </div>
</div>
@endsection
@section('more-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to get today's date in yyyy-MM-dd format
    function getTodayDate() {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
        const dd = String(today.getDate()).padStart(2, '0');
        return `${yyyy}-${mm}-${dd}`;
    }

    // Function to update localStorage
    function updateLocalStorage() {
        localStorage.setItem('tasks', JSON.stringify(tasks));
    }

    // Retrieve tasks from localStorage
    let tasks = JSON.parse(localStorage.getItem('tasks')) || [];

    // Get the taskIndex from the URL
    const pathParts = window.location.pathname.split('/');
    const taskIndex = pathParts.includes('edit-task') ? parseInt(pathParts[pathParts.indexOf('edit-task') + 1], 10) : null;

    // If taskIndex is not a number or out of range, redirect back
    if (isNaN(taskIndex) || taskIndex < 0 || taskIndex >= tasks.length) {
        window.history.back();
        return;
    }

    // Select the input elements
    const taskNameInput = document.querySelector('input[name="TaskName"]');
    const dueDateInput = document.querySelector('input[name="DueDate"]');
    const taskDetailTextarea = document.querySelector('textarea[name="TaskDetail"]');

    // Set the initial values from localStorage if they exist
    if (tasks[taskIndex]) {
        taskNameInput.value = tasks[taskIndex].TaskName || '';
        dueDateInput.value = tasks[taskIndex].DueDate && tasks[taskIndex].DueDate !== '-/-/-' ? tasks[taskIndex].DueDate : getTodayDate();
        taskDetailTextarea.value = tasks[taskIndex].TaskDetail || '';
    }

    // Add event listeners to update localStorage on changes
    taskNameInput.addEventListener('change', function() {
        tasks[taskIndex].TaskName = taskNameInput.value;
        updateLocalStorage();
    });

    dueDateInput.addEventListener('change', function() {
        const dueDateValue = dueDateInput.value === '-/-/-' ? getTodayDate() : dueDateInput.value;
        tasks[taskIndex].DueDate = dueDateValue;
        dueDateInput.value = dueDateValue; // Update the input field
        updateLocalStorage();
    });

    taskDetailTextarea.addEventListener('change', function() {
        tasks[taskIndex].TaskDetail = taskDetailTextarea.value;
        updateLocalStorage();
    });
//
    // Function to update an individual attachment
    function updateAttachment(index, name, link) {
        if (tasks[taskIndex].TaskAttachments && tasks[taskIndex].TaskAttachments[index]) {
            tasks[taskIndex].TaskAttachments[index].Name = name;
            tasks[taskIndex].TaskAttachments[index].Link = link;
            updateLocalStorage();
        }
    }

document.querySelector('.add-attachment-btn').addEventListener('click', function() {
    // No need to save currentAttachments here since we're directly appending the new input

    const attachmentsContainer = document.getElementById('attachments-container');
    const newAttachmentIndex = document.querySelectorAll('.attachment-group').length; // Use to set data-index for the new remove button

    // Create and append the new attachment input group directly
    const attachmentInputGroup = document.createElement('div');
    attachmentInputGroup.className = 'flex justify-between items-center attachment-group';
    attachmentInputGroup.innerHTML = `
        <input type="text" placeholder="Document Name *" name="Name" class="w-[290px] h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none">
        <input type="text" placeholder="Document URL *" name="Link" class="w-[290px] h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none">
        <button class="remove-attachment-btn text-red-500" data-index="${newAttachmentIndex}"><i class="fas fa-trash-alt fa-lg"></i></button>
    `;

    // Insert the new group before the Add Attachment button
    const addAttachmentBtnGroup = document.querySelector('.add-attachment-btn').parentNode;
    attachmentsContainer.insertBefore(attachmentInputGroup, addAttachmentBtnGroup);

    // Add event listener to the newly created remove button
    attachmentInputGroup.querySelector('.remove-attachment-btn').addEventListener('click', removeAttachmentInput);
});

//

//
    document.getElementById('save-task-btn').addEventListener('click', function() {
        // Update task details based on current input values
        if (tasks.length > taskIndex) {
            tasks[taskIndex].TaskName = taskNameInput.value;
            tasks[taskIndex].DueDate = dueDateInput.value;
            tasks[taskIndex].TaskDetail = taskDetailTextarea.value;

            // Iterate over attachment input groups to update TaskAttachments
            const attachmentGroups = document.querySelectorAll('.attachment-group');
            tasks[taskIndex].TaskAttachments = Array.from(attachmentGroups).map((group, index) => {
                return {
                    Name: group.querySelector('[name="Name"]').value,
                    Link: group.querySelector('[name="Link"]').value
                };
            });
        }

        updateLocalStorage(); // Save the updated tasks array to localStorage
        window.location.href = '/participant/projects/create'; // Redirect
    });
//
    // Function to update localStorage
    function updateLocalStorage() {
        localStorage.setItem('tasks', JSON.stringify(tasks));
    }

    // Function to update task name in tasks array and localStorage
    function updateTaskName() {
        if (tasks.length > taskIndex) { // Check if the task exists
            tasks[taskIndex].TaskName = taskNameInput.value;
            updateLocalStorage();
        }
    }

    // Function to update due date in tasks array and localStorage
    function updateDueDate() {
        if (tasks.length > taskIndex) { // Check if the task exists
            const dueDateValue = dueDateInput.value === '-/-/-' ? getTodayDate() : dueDateInput.value;
            tasks[taskIndex].DueDate = dueDateValue;
            dueDateInput.value = dueDateValue; // Update the input field
            updateLocalStorage();
        }
    }

    // Set the initial values from localStorage if they exist
    if (tasks.length > 0 && tasks[taskIndex]) {
        taskNameInput.value = tasks[taskIndex].TaskName || '';
        const dueDateValue = tasks[taskIndex].DueDate && tasks[taskIndex].DueDate !== '-/-/-' ? tasks[taskIndex].DueDate : getTodayDate();
        dueDateInput.value = dueDateValue;
        tasks[taskIndex].DueDate = dueDateValue; // Update the array if necessary
        updateLocalStorage();
    }

    // Add event listeners to update localStorage on changes
    taskNameInput.addEventListener('change', updateTaskName);
    dueDateInput.addEventListener('change', updateDueDate);
    // Initially bind the addAttachmentInput function to the add button
    document.querySelector('.add-attachment-btn').addEventListener('click', addAttachmentInput);

    function addAttachmentInput() {
        // Adds a new empty attachment to the task object
        if (!tasks[taskIndex].TaskAttachments) {
            tasks[taskIndex].TaskAttachments = [];
        }
        tasks[taskIndex].TaskAttachments.push({ Name: '', Link: '' });
        updateLocalStorage();
        loadAttachments(); // Reload the attachment inputs
    }

    function removeAttachmentInput(event) {
        const attachmentIndex = parseInt(event.target.closest('.remove-attachment-btn').getAttribute('data-index'), 10);
        tasks[taskIndex].TaskAttachments.splice(attachmentIndex, 1);
        updateLocalStorage();
        // Instead of reloading all attachments, just remove the specific attachment element
        event.target.closest('.attachment-group').remove();
        // Update data-index for remaining attachments
        document.querySelectorAll('.attachment-group').forEach((group, index) => {
            group.querySelector('.remove-attachment-btn').setAttribute('data-index', index);
        });
    }

    function loadAttachments() {
        const attachmentsContainer = document.getElementById('attachments-container');
        attachmentsContainer.innerHTML = ''; // Clear current inputs

        tasks[taskIndex].TaskAttachments.forEach((attachment, index) => {
            const attachmentInputGroup = document.createElement('div');
            attachmentInputGroup.className = 'flex justify-between items-center attachment-group';
            attachmentInputGroup.innerHTML = `
                <input type="text" placeholder="Document Name *" name="Name" class="w-[290px] h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none" value="${attachment.Name}">
                <input type="text" placeholder="Document URL *" name="Link" class="w-[290px] h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none" value="${attachment.Link}">
                <button class="remove-attachment-btn text-red-500" data-index="${index}"><i class="fas fa-trash-alt fa-lg"></i></button>
            `;

            attachmentsContainer.appendChild(attachmentInputGroup);

            // Add event listener to the newly created remove button
            attachmentInputGroup.querySelector('.remove-attachment-btn').addEventListener('click', removeAttachmentInput);
        });

        // Add the "Add Attachment" button after all existing attachment inputs
        const addAttachmentBtnGroup = document.createElement('div');
        addAttachmentBtnGroup.className = 'flex justify-center mt-4';
        addAttachmentBtnGroup.innerHTML = '<button class="add-attachment-btn w-6 h-6 bg-primary text-white rounded-full"><i class="fas fa-plus"></i></button>';

        attachmentsContainer.appendChild(addAttachmentBtnGroup);

        // Add event listener to the "Add Attachment" button
        addAttachmentBtnGroup.querySelector('.add-attachment-btn').addEventListener('click', addAttachmentInput);
    }

    // Initial loading of attachments and the "Add Attachment" button
    loadAttachments();
});

</script>
@endsection
