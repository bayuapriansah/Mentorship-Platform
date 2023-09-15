@extends('layouts.admin2')

@section('content')
    <div class="flex justify-between mb-10">
        <h3 class="text-dark-blue font-medium text-xl" id="BitTitle">Students Testimonial</h3>
    </div>

    @include('flash-message')

    <table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16">
        <thead class="text-dark-blue">
            <tr>
                <th>No</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Institute Name</th>
                <th>Supervisor Name</th>
                <th>Staff Name</th>
                <th>Show Testimonial</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->institution ? $student->institution->name : 'Not Registered Yet' }}</td>
                    <td>{{ $student->mentor ? $student->mentor->first_name.' '.$student->mentor->last_name : 'Student not completed the registration yet' }}</td>
                    <td>{{ $student->staff ? $student->staff->first_name.' '.$student->staff->last_name : 'Student not completed the registration yet' }}</td>
                    <td><button class="px-4 py-2 bg-blue-500 text-white rounded cursor-pointer hover:bg-blue-600" data-modal-show="feedbackModal-{{ $student->id }}">Show Testimonial</button></td>
                </tr>
                <!-- Feedback Modal -->
                <div id="feedbackModa-{{ $student->id }}" tabindex="-1" data-modal-target="feedbackModa-{{ $student->id }}" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-lg max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                    Testimonial from {{ $student->first_name }} {{ $student->last_name }}
                                </h3>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="feedbackModal-{{ $student->id }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-6 space-y-6">
                                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                    {{ $student->feedback->feedback }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

<!-- Default Modal -->
<div id="feedbackModal-{{ $student->id }}" tabindex="-1" data-modal-target="feedbackModal-{{ $student->id }}" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                    Testimonial from {{ $student->first_name }} {{ $student->last_name }}
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="medium-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    {{ $student->feedback->feedback }}
                </p>
            </div>
        </div>
    </div>
</div>

            @endforeach
        </tbody>
    </table>
@endsection
