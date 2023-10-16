<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function studentsInfo()
    {
        $data['testimonials'] = [
            [
                "id" => '1',
                "name" => "Deepanshu Jain",
                "email" => "deepanshu22100@gmail.com",
                "feedback" => "Thank you Intel SIP for letting me have this wonderful experience of working and developing AI projects. I learned a lot about how real-world problems are tackled and the importance of deadlines for the smooth conduction of the company. I am certain that the impact these past 4 months had on me will help me in my future endeavors. It was a pleasure working and learning on this platform."
            ],
            [
                "id" => '2',
                "name" => "Tanay Sharma",
                "email" => "tanay1894@gmail.com",
                "feedback" => "These projects allowed me to gain valuable hands-on experience in the world of AI and its various applications. Throughout these projects, I not only applied theoretical knowledge but also gained practical insights into the AI development process. This internship provided me with a holistic understanding of AI, from natural language processing and computer vision to Statical Learning. It was a rewarding experience that has equipped me with skills and knowledge to contribute effectively to the ever-evolving field of Artificial Intelligence."
            ],
            [
                "id" => '3',
                "name" => "Pranav Hyagreev",
                "email" => "pranavhyagreev.srini2021@vitstudent.ac.in",
                "feedback" => "It was a cherishing experience. Projects were quite detailed and challenging. Tasks were well defined. Very Professional Guidance and Reviews .The timelines were quite generous and fair. Learned a lot personally to improve(based on feedback) and was delighted to interact with experienced professionals. I Would like to thank all of you for providing me this opportunity. Wishing you very good luck! Pranav"
            ],
            [
                "id" => '4',
                "name" => "Vaatsalya Babbar",
                "email" => "babbarvaatsalya@gmail.com",
                "feedback" => "This internship has been one of the best experiences I've had both academically and as a person. I was able to interact with one of the best minds in the field of AI and learnt a lot!"
            ],
            [
                "id" => '5',
                "name" => "Aryaman Singh Fauzdar",
                "email" => "aryaman.209301565@muj.manipal.edu",
                "feedback" => "It has been a great and lovely experience for me. Enjoyed the learning that I got through this well structured program, and got a chance to work on such wonderful projects. Would be delighted to be provided any future opportunities ahead with you. Thank you"
            ],
            [
                "id" => '6',
                "name" => "Kapish Jain",
                "email" => "kapish.219310297@muj.manipal.edu",
                "feedback" => "My experience in the virtual internship program at Intel has been exceptional. The onboarding was smooth, and the team's support was consistently present. The variety of projects I worked on and the mentorship I received greatly enhanced my skills and industry knowledge."
            ],
            [
                "id" => '7',
                "name" => "Abhinav bazaru",
                "email" => "abhinav.219310217@muj.manipal.edu",
                "feedback" => "The Simulated internship program was a rewarding experience to improve my knowledge in different machine learning domains and put my theoretical knowledge to practical use.The platform was well structured and the project coordinators were very helpful and look forward to working on here again"
            ],
            [
                "id" => '8',
                "name" => "Nivedita Tibrewala",
                "email" => "nivedita8495@gmail.com",
                "feedback" => "I am very thankful for the opportunity that I was given. It was a very helpful program. It helped me a lot as I made three different projects. I also got to learn a lot."
            ],
            [
                "id" => '9',
                "name" => "Srivaths Gondi",
                "email" => "srivathsgondi19@gmail.com",
                "feedback" => "This internship period of 4 months was quite insightful, I learned to organize and surpass many hurdles while gathering a simulated industry experience."
            ],
            [
                "id" => '10',
                "name" => "Satyam Kumar",
                "email" => "satyamkumar9742@gmail.com",
                "feedback" => "It was really a nice opportunity to gain experience in machine learning projects"
            ]
        ];
        return view('homepage.students-info', compact('data'));
    }

    public function institutesInfo()
    {
        return view('homepage.institutes-info');
    }

    public function partnersInfo()
    {
        return view('homepage.partners-info');
    }

    public function aboutus()
    {
        return view('homepage.aboutus');
    }
}
