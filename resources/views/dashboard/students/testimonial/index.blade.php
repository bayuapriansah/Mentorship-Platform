@extends('layouts.admin2')

@section('title', 'Testimonials')

@section('more-css')
    @livewireStyles
@endsection

@section('content')
{{-- Header --}}
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-dark-blue font-medium text-[1.375rem]">
        Participants Testimonial
    </h1>
</div>
{{-- ./Header --}}

<div class="mt-6">
    @livewire('testimonials-table')
</div>

{{-- Modal --}}
<button
    hidden
    type="button"
    id="open-testimonial-modal"
    data-modal-target="testimonial-modal"
    data-modal-toggle="testimonial-modal">
</button>

<div id="testimonial-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg text-darker-blue font-medium">
                    Testimonial from
                    <span id="show-testimonial-name"></span>
                </h3>

                <button type="button" class="text-grey" data-modal-hide="testimonial-modal">
                    <i class="fas fa-times-circle fa-lg"></i>
                </button>
            </div>
            <!-- Modal body -->
            <div class="px-5 pt-4 pb-6">
                <p id="show-testimonial-content" class="text-sm leading-relaxed"></p>
            </div>
        </div>
    </div>
</div>
{{-- ./Modal --}}
@endsection

@section('more-js')
    @livewireScripts

    <script>
        function showTestimonial(name, content) {
            document.getElementById('show-testimonial-name').innerHTML = name
            document.getElementById('show-testimonial-content').innerHTML = content
            document.getElementById('open-testimonial-modal').click()
        }
    </script>
@endsection
