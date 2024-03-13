<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index()
    {
        $faq = [
            'General' => [],
            'Skills Track' => [],
            'Entrepreneur Track' => [],
        ];

        $faq['General'] = [
            [
                'question' => 'What is the difference between the Skills Track and the Entrepreneur Track?',
                'answer' => 'The Mentorship Program offers two different tracks to support the different goals of all participants. The core difference between these tracks is that the Skills Track is designed for participants who want to extend their knowledge of AI and develop their technical skills, while the Entrepreneur Track is designed for participants who want to continue to develop the project they submitted to the Intel AI Global Impact Festival.'
            ],
            [
                'question' => 'How long is this program?',
                'answer' => 'The program is 10 weeks long.'
            ],
            [
                'question' => 'Will there be a mentor assigned to me?',
                'answer' => 'You will have two official mentors for this program. One mentor from Intel and one mentor from the Mentorship Program’s team will be assigned to you upon registration. You can chat with your mentors via the messaging feature present under each task of a project.'
            ],
            [
                'question' => 'What are the expectations from a participant in this program?',
                'answer' => 'Each participant is expected to enroll in and complete one project on the platform over the 10 week period. The participant must choose either the Skills Track or the Entrepreneur Track and complete all tasks associated with their respective projects to the satisfaction of their mentorship team. Participants should submit each task before the assigned deadline passes.'
            ],
        ];

        $faq['Skills Track'] = [
            [
                'question' => 'What types of projects are available for the Skills Track?',
                'answer' => 'There are three AI projects available that are focused on one of the three domains: Machine Learning (ML), Natural Language Processing (NLP), and Computer Vision (CV).'
            ],
            [
                'question' => 'How do I enroll in a project?',
                'answer' => 'When you go to the Available Project(s) page, you will see the list of all available projects. To enroll, simply click on the View Project button which will bring you to the project page of the project you’ve selected. Read the project description and if the project appeals to you, click on the enroll button. Note that you can only be enrolled in one project for the mentorship, so choose wisely.'
            ],
            [
                'question' => 'What are the requirements to complete a project?',
                'answer' => 'Each project has its own specific requirements outlined in the project’s tasks. Once you submit a task, your mentors will mark your task as pass or return it to you for revisions. You must pass all the tasks to complete a project within the 10 weeks of the mentorship program.'
            ],
            [
                'question' => 'Are there any deadlines for submitting my work?',
                'answer' => 'The deadlines for each task are provided on the task, however, these are soft deadlines. You will be able to submit a task after the deadline, however, it is advised to always submit before the deadline to keep you on track for the project.'
            ],
            [
                'question' => 'When do I see the next task?',
                'answer' => 'After you have submitted a past task or the deadline of a task has passed you will see the next task.'
            ],
        ];

        $faq['Entrepreneur Track'] = [
            [
                'question' => 'Can I select a new project for this track?',
                'answer' => 'The goal for this track is to take the project that you have submitted for the Intel AI Global Impact Festival 2023 to the next level. Therefore, this track will be based on the submitted project.'
            ],
            [
                'question' => 'What happens if my group mates choose the Skills Track will I be able to continue on for the Entrepreneur Track?',
                'answer' => 'Yes, you can! You can take on the Entrepreneur Track as an individual or a group.'
            ],
        ];


        return view('faq', compact('faq'));
    }
}
