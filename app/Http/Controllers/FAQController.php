<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index()
    {
        // return view('old-faq');

        $faq = [
            'General' => [],
            'Skills Track' => [],
            'Entrepreneur Track' => [],
        ];

        $faq['General'] = [
            [
                'question' => 'What types of projects are available on the website?',
                'answer' => 'We have various AI projects ranging from Machine Learning (ML), Natural Language Processing (NLP), to Computer Vision (CV).'
            ],
            [
                'question' => 'How do I enroll in a project?',
                'answer' => 'When you go to the Internship Projects page you will see the list of all available projects. To enroll simply click on the enroll button. Note that you can only be enrolled in one project at a time therefore, you will be able to enroll in another project after you have completed the project you are currently enrolled in.'
            ],
            [
                'question' => 'What are the requirements to enroll in a project?',
                'answer' => 'To enroll in a project you must be currently attending an institute which is involved in the Simulated Internship Program.'
            ],
            [
                'question' => 'What are the requirements to complete a project?',
                'answer' => 'Each project has it\'s own specific requirements. After you enroll in a project you will receive a variety of tasks which you will need to complete. Once you submit a task, your institutions supervisor mark your task as pass or return it to you for revisions. You must pass all the tasks to complete a project.'
            ],
            [
                'question' => 'How long is this program?',
                'answer' => 'The program is typically 4 months long and comprised of projects of various durations (generally 1 month).'
            ],
            [
                'question' => 'Are there any deadlines for applying for projects?',
                'answer' => 'The deadlines for each task/project are the soft deadlines. These deadlines are what your customer is expecting you to meet but, your educational institute will be responsible for fixing hard deadlines.'
            ],
            [
                'question' => 'Can I work on more than one project at a time?',
                'answer' => 'You can only be enrolled in one project at a time. However, if the deadline of a project has passed, you can enroll in a second one while you finish the first project.'
            ],
            [
                'question' => 'Will I receive college credit for my internship?',
                'answer' => 'College credit specifics is dependent on your insitution. Please contact your institution for more information.'
            ],
            [
                'question' => 'Are there any opportunities for full-time employment after the program?',
                'answer' => 'We cannot guarantee employment after this program.'
            ],
            [
                'question' => 'Will there be a supervisor or mentor assigned to me during the internship?',
                'answer' => 'There will be one supervisor assigned to you from your own institute, and one staff member assigned to you from the Simulated Internship Platform team. You can chat with the supervisor and the staff member for any required support using the messaging feature present under each task of a project.'
            ],
            [
                'question' => 'What are the expectations from an intern during an internship project?',
                'answer' => 'An intern is expected to enroll in and complete multiple projects on the platform based on the duration of their internship. For each project, they must pass all the tasks inside the recommended project duration where each tasks should be completed inside the recommended task duration.'
            ],
            [
                'question' => 'I see an industry partner listed but there is not a project listed by them?',
                'answer' => 'We have various industry partners however, we can only run a limited number of projects at a time. Our list of industry partners represents those we have worked with, either currently or in the past.'
            ],
        ];

        return view('faq', compact('faq'));
    }
}
