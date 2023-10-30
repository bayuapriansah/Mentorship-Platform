@extends('layouts.index')
@section('content')
{{-- Body Contents --}}
<div style="background-image: url({{ asset('assets/img/for_students/two-students.jpeg') }}); background-size: cover;" class="max-w-full bg-no-repeat phone:bg-right-min-28 hd:bg-top-min-20 laptop:bg-top-min-20 fhd:bg-top-min-32 py-24">
    <div class="max-w-screen-xl mx-auto px-6 hd:py-24 ">
        <div class="grid md:grid-cols-2 gap-4 items-center ">
            <div class="my-auto bg-darker-blue/[0.9] rounded-2xl px-8 py-4 mt-48 hd:mt-0 hd:px-16 hd:py-8">
                <h2 class="intelOne text-white font-bold text-xl hd:text-3xl leading-11">
                    <span>Information for</span> <span class="text-light-brown"> Students</span>
                </h2>
                <span class="intelOne text-white font-light text-sm hd:text-lg leading-6">Join today to work on real-world
                    projects and kick start your career!</span>
                <div class="flex py-4">
                    <a href="{{ route('multiLogIn') }}"
                       class="intelOne text-dark-blue text-sm font-normal bg-white hover:bg-neutral-300 px-8 py-1.5 hd:px-16 hd:py-3.5 rounded-full">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- Body Content 2 --}}
    <div class="max-w-screen-xl mx-auto px-6 py-4 pt-20" id="AiForFuture">
        <div class="grid md:grid-cols-2 gap-4 items-center">
            <div class="my-auto">
                <h2 class="intelOne text-dark-blue font-bold text-4xl">Information<br><span class="text-light-brown"> For Students</span></h2>
            </div>
            <div class="relative my-auto">
                <p class="mb-4 text-black text-justify">On this platform, students will have the opportunity to work on AI projects in an online work-like environment. Most projects or tutorials found online walk students through projects step by step, giving them a clear pathway from the original idea to a solution. On this platform, the projects students will be working on have been designed to walk students through a project as it manifests itself in a work-like setting. The goal is for students to develop their independence by finding solutions to problems, time management and responsibility by meeting deadlines, and accountability for their work as the owners of their tasks. Once the students have completed their simulated internship, not only will they have grown as developers, but they will have grown their project portfolio.
                </p>
                <p class="m-0 text-black text-justify">
                    The projects our students will be working on have been designed to give students practical skills that will be beneficial in industry. From this program, students will work on the following skills:
                </p>
            </div>
        </div>
    </div>

    {{-- Body Content 2.1 --}}
    <div class="max-w-screen-xl mx-auto px-6 py-4" id="AiForFuture">
        <div class="grid md:grid-cols-2 gap-4 items-center">
            <div class="my-auto">
                {{-- <h2 class="intelOne text-dark-blue font-bold text-4xl">Information<br><span class="text-light-brown"> For Students</span></h2> --}}
            </div>
            <div class="relative my-auto bg-[#F3F3F3] rounded-xl px-8 py-4">
                <p class="mb-4 text-black text-justify">
                    <table class="table-fixed text-darker-blue font-medium">
                        <tr>
                        <td class="pb-4">
                            <div class="flex items-center justify-center w-6 h-6 mr-2 bg-darker-blue rounded-full">
                                <i class="fas fa-check text-white"></i>
                            </div>
                        </td>
                        <td class="pb-4">Data Collection</td>
                        <td class="pb-4">
                            <div class="flex items-center justify-center w-6 h-6 ml-16 mr-2 bg-darker-blue rounded-full">
                                <i class="fas fa-check text-white"></i>
                            </div>
                        </td>
                        <td class="pb-4">Data Wrangling</td>
                        </tr>
                        <tr>
                        <td class="pb-4">
                            <div class="flex items-center justify-center w-6 h-6 mr-2 bg-darker-blue rounded-full">
                                <i class="fas fa-check text-white"></i>
                            </div>
                        </td>
                        <td class="pb-4">Data Pipelining</td>
                        <td class="pb-4">
                            <div class="flex items-center justify-center w-6 h-6 ml-16 mr-2 bg-darker-blue rounded-full">
                                <i class="fas fa-check text-white"></i>
                            </div>
                        </td>
                        <td class="pb-4">Data Model Building</td>
                        </tr>
                        <tr>
                        <td class="pb-4">
                            <div class="flex items-center justify-center w-6 h-6 mr-2 bg-darker-blue rounded-full">
                                <i class="fas fa-check text-white"></i>
                            </div>
                        </td>
                        <td class="pb-4">AI Model Evaluation</td>
                        <td class="pb-4">
                            <div class="flex items-center justify-center w-6 h-6 ml-16 mr-2 bg-darker-blue rounded-full">
                                <i class="fas fa-check text-white"></i>
                            </div>
                        </td>
                        <td class="pb-4">AI Solution Proof of Concept (POC) Deployment</td>
                        </tr>
                    </table>
                </p>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-center pt-20">
        <div class="max-w-screen-xl text-center">
            <p class="text-dark-blue font-bold py-3 text-4xl">How it Works ?</p>
        </div>
    </div>

    {{-- STEP --}}
    <div class="max-w-screen-xl mx-auto px-6 py-4 pt-20">
        <div class="grid md:grid-cols-2 gap-4 items-center">
            <div class="relative my-auto">
                <div class="relative z-30 rounded-lg mr-16">
                    <img src="{{ asset('assets/img/for_students/step1.svg') }}" loading="lazy" class="inset-0 w-1/4 h-1/4 ml-auto" alt="for students">
                    <h1 class="text-2xl font-medium text-right py-3">Register & Login</h1>
                    <p class="text-black font-normal text-right py-3">Initiate your path to practical learning and industry experience on our Simulated Internship Platform. Register & Login to hone your skills, engage in professional interactions, and cultivate a notable portfolio for a competitive career landscape.</p>
                </div>
            </div>
            <div class="relative my-auto">
                <div class="relative z-30 rounded-lg">
                    <img src="{{ asset('assets/img/dots-1.png') }}" loading="lazy" alt="dots" class="absolute right-0 z-10" aria-hidden="true">
                    <img src="{{ asset('assets/img/for_students/stepimg1.svg') }}" loading="lazy" class="relative inset-0 z-20 w-full h-full" alt="for students">
                </div>
            </div>
        </div>
    </div>

    {{-- STEP --}}
    <div class="max-w-screen-xl mx-auto px-6 py-4 pt-20">
        <div class="grid md:grid-cols-2 gap-4 items-center">
            <div class="relative my-auto">
                <div class="relative z-30 rounded-lg mr-16">
                    <img src="{{ asset('assets/img/dots-1.png') }}" loading="lazy" alt="dots" class="absolute left-0 z-10" aria-hidden="true">
                    <img src="{{ asset('assets/img/for_students/stepimg2.svg') }}" loading="lazy" class="relative inset-0 z-20 w-full h-full" alt="for students">
                </div>
            </div>
            <div class="relative my-auto">
                <div class="relative z-30 rounded-lg">
                    <img src="{{ asset('assets/img/for_students/step2.svg') }}" loading="lazy" class="inset-0 w-1/4 h-1/4" alt="for students">
                    <h1 class="text-2xl font-medium text-left py-3">Enroll in a project</h1>
                    <p class="text-black font-normal text-left py-3">Enroll in one of our various projects to begin the hands-on learning journey.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- STEP --}}
    <div class="max-w-screen-xl mx-auto px-6 py-4 pt-20">
        <div class="grid md:grid-cols-2 gap-4 items-center">
            <div class="relative my-auto">
                <div class="relative z-30 rounded-lg mr-16">
                    <img src="{{ asset('assets/img/for_students/step3.svg') }}" loading="lazy" class="inset-0 w-1/4 h-1/4 ml-auto" alt="for students">
                    <h1 class="text-2xl font-medium text-right py-3">Begin & Work on the Task</h1>
                    <p class="text-black font-normal text-right py-3">Dive into the given tasks and transform your knowledge into action. During these tasks, you will engage with real-world challenges, and work through them, to enrich your skill set.</p>
                </div>
            </div>
            <div class="relative my-auto">
                <div class="relative z-30 rounded-lg">
                    <img src="{{ asset('assets/img/dots-1.png') }}" loading="lazy" alt="dots" class="absolute right-0 z-10" aria-hidden="true">
                    <img src="{{ asset('assets/img/for_students/stepimg3.svg') }}" loading="lazy" class="relative inset-0 z-20 w-full h-full" alt="for students">
                </div>
            </div>
        </div>
    </div>

    {{-- STEP --}}
    <div class="max-w-screen-xl mx-auto px-6 py-4 pt-20">
        <div class="grid md:grid-cols-2 gap-4 items-center">
            <div class="relative my-auto">
                <div class="relative z-30 rounded-lg mr-16">
                    <img src="{{ asset('assets/img/dots-1.png') }}" loading="lazy" alt="dots" class="absolute left-0 z-10" aria-hidden="true">
                    <img src="{{ asset('assets/img/for_students/stepimg4.svg') }}" loading="lazy" class="relative inset-0 z-20 w-full h-full" alt="for students">
                </div>
            </div>
            <div class="relative my-auto">
                <div class="relative z-30 rounded-lg">
                    <img src="{{ asset('assets/img/for_students/step4.svg') }}" loading="lazy" class="inset-0 w-1/4 h-1/4" alt="for students">
                    <h1 class="text-2xl font-medium text-left py-3">Submit the task</h1>
                    <p class="text-black font-normal text-left py-3">Once a task is completed, you will submit your work online so you can track and mark your progress throughout the project. Your task will then be evaluated by our industry partner, your supervisor, or our support team.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- STEP --}}
    <div class="max-w-screen-xl mx-auto px-6 py-4 pt-20">
        <div class="grid md:grid-cols-2 gap-4 items-center">
            <div class="relative my-auto">
                <div class="relative z-30 rounded-lg mr-16">
                    <img src="{{ asset('assets/img/for_students/step5.svg') }}" loading="lazy" class="inset-0 w-1/4 h-1/4 ml-auto" alt="for students">
                    <h1 class="text-2xl font-medium text-right py-3">Move onto the next task</h1>
                    <p class="text-black font-normal text-right py-3">Advance to the next task to stay on top of the work deadlines. Additionally, keep track of past task submissions as your work receives review and feedback</p>
                </div>
            </div>
            <div class="relative my-auto">
                <div class="relative z-30 rounded-lg">
                    <img src="{{ asset('assets/img/dots-1.png') }}" loading="lazy" alt="dots" class="absolute right-0 z-10" aria-hidden="true">
                    <img src="{{ asset('assets/img/for_students/stepimg5.svg') }}" loading="lazy" class="relative inset-0 z-20 w-full h-full" alt="for students">
                </div>
            </div>
        </div>
    </div>

    {{-- STEP --}}
    <div class="max-w-screen-xl mx-auto px-6 py-4 pt-20">
        <div class="grid md:grid-cols-2 gap-4 items-center">
            <div class="relative my-auto">
                <div class="relative z-30 rounded-lg mr-16">
                    <img src="{{ asset('assets/img/dots-1.png') }}" loading="lazy" alt="dots" class="absolute left-0 z-10" aria-hidden="true">
                    <img src="{{ asset('assets/img/for_students/stepimg6.svg') }}" loading="lazy" class="relative inset-0 z-20 w-full h-full" alt="for students">
                </div>
            </div>
            <div class="relative my-auto">
                <div class="relative z-30 rounded-lg">
                    <img src="{{ asset('assets/img/for_students/step6.svg') }}" loading="lazy" class="inset-0 w-1/4 h-1/4" alt="for students">
                    <h1 class="text-2xl font-medium text-left py-3">Certificate of Participation</h1>
                    <p class="text-black font-normal text-left py-3">Once all tasks are completed, you will repeat this process for 3 complete projects. Once you complete all 3 designated projects within the 4-month window, you will unlock access to receive a certificate of participation, showcasing your dedication and acquired skills.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Body Testimonials --}}
    <div class="max-w-screen-xl mx-auto px-6 py-4 mt-20 relative">
        <div class="flex justify-between items-center mb-4">
            <h2 class="intelOne text-dark-blue font-bold text-3xl pb-8">Testimonial From Students</h2>
            <div class="flex space-x-4">
                <button class="bg-white border-2 border-dark-blue rounded-full p-2" id="testimonial-swiper-button-prev">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-6 w-6 text-dark-blue">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="bg-white border-2 border-dark-blue rounded-full p-2" id="testimonial-swiper-button-next">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-6 w-6 text-dark-blue">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="swip-testimonial">
            <div class="swiper-wrapper">
                @foreach ($data['testimonials'] as $testimonial)
                    <!-- Slide -->
                    <div class="swiper-slide">
                        <div
                            class="block p-3 rounded-lg shadow-lg hover:shadow-xl hover:border-2 border-2 hover:border-darker-blue border-[#A4AADC] bg-white max-w-sm h-auto overflow-hidden">
                            <div class="flex space-x-2">
                                <div class="flex-col">
                                    <p
                                        class="intelOne text-dark-blue font-bold text-xl leading-7 m-0 overflow-ellipsis px-2 overflow-hidden">
                                        {{ $testimonial['name'] }}
                                    </p>
                                    <p class="text-black font-normal text-sm mt-2 overflow-ellipsis px-2 overflow-hidden">
                                        Student
                                    </p>
                                    {{-- <div class="pt-2">
                                        <p
                                            class="text-dark-blue font-normal text-sm bg-lightest-blue py-0.5 text-center shadow-lg rounded-lg p-4 overflow-ellipsis px-2 overflow-hidden">
                                            {{ $testimonial['email'] }}
                                        </p>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="text-grey font-normal text-base text-justify mb-2 py-4 overflow-ellipsis px-2 overflow-hidden">
                                {{ $testimonial['feedback'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Body Content 3 --}}
    <div class="max-w-screen-xl mx-auto px-6 pt-20 mb-20 flex flex-col md:flex-row md:space-x-4 items-center relative">
        <div class="md:flex-1 flex items-center mb-10">  <!-- added flex and items-center classes here -->
            <div class="flex flex-col px-4">
                <h2 class="intelOne text-dark-blue font-bold text-4xl">Read More<i class="fa-solid fa-arrow-right fa-rotate-90 ml-8 hidden"></i><i class="fa-solid fa-arrow-right fa-rotate-90 ml-8 hidden"></i></h2>
            </div>
        </div>
        <div class="md:flex-1">
            <div class="flex flex-col px-4">
                <img src="{{ asset('assets/img/for_institution.png') }}" loading="lazy" class="relative z-20" alt="for students">
                <h1 class="text-dark-blue text-2xl font-bold py-3">For Institutes</h1>
                <p class="text-black font-normal text-sm text-justify py-3">Enhanced Student Employability, Collaborate
                    with Industry leaders, Supervise Real-World AI Projects</p>
            </div>
        </div>
        <div class="md:flex-1">
            <div class="flex flex-col px-4">
                <img src="{{ asset('assets/img/for_industries.png') }}" loading="lazy" class="relative z-20" alt="for students">
                <h1 class="text-dark-blue text-2xl font-bold py-3">For Industries</h1>
                <p class="text-black font-normal text-sm text-justify py-3">Identify Top Future Talents, Collaborate
                    with Top Institutions, Explore Fresh Perspectives on Industry Use-Cases</p>
            </div>
        </div>
    </div>
@endsection
@section('more-js')
<script>
// New Testimonial Swiper
const swiperTestimonial = new Swiper('.swip-testimonial', {
    slidesPerView: 3,
    spaceBetween: 30,
    navigation: {
        nextEl: '#testimonial-swiper-button-next',
        prevEl: '#testimonial-swiper-button-prev',
    },
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10
        },
        480: {
            slidesPerView: 1,
            spaceBetween: 10
        },
        640: {
            slidesPerView: 2,
            spaceBetween: 10
        },
        950: {
            slidesPerView: 3,
            spaceBetween: 30
        }
    }
});
</script>
@endsection
