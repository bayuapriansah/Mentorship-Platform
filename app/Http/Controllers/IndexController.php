<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    public function index()
    {
        if(Auth::guard('student')->check()){
            $projects = Project::whereNotIn('id', function($query){
                            $query->select('project_id')->from('enrolled_projects');
                            $query->where('student_id',Auth::guard('student')->user()->id);
                        })->where('institution_id', Auth::guard('student')->user()->institution_id)
                        ->where('status', 'publish')
                        ->orWhere('institution_id', null)->whereNotIn('id', function($query){
                            $query->select('project_id')->from('enrolled_projects');
                            $query->where('student_id',Auth::guard('student')->user()->id);
                        })
                        ->where('status', 'publish')
                        ->take(3)->get();

        }else{
            // $projects = Project::where('status', 'publish')->take(3)->get();
            $projects = Project::where('status', 'publish')->get();
        }

        $testimonials = [
            [
                "id" => '1',
                "name" => "Deepanshu Jain",
                "feedback" => "Thank you Intel SIP for letting me have this wonderful experience of working and developing AI projects. I learned a lot about how real-world problems are tackled and the importance of deadlines for the smooth conduction of the company. I am certain that the impact these past 4 months had on me will help me in my future endeavors. It was a pleasure working and learning on this platform."
            ],
            [
                "id" => '2',
                "name" => "Tanay Sharma",
                "feedback" => "These projects allowed me to gain valuable hands-on experience in the world of AI and its various applications. Throughout these projects, I not only applied theoretical knowledge but also gained practical insights into the AI development process. This internship provided me with a holistic understanding of AI, from natural language processing and computer vision to Statical Learning. It was a rewarding experience that has equipped me with skills and knowledge to contribute effectively to the ever-evolving field of Artificial Intelligence."
            ],
            [
                "id" => '3',
                "name" => "Pranav Hyagreev",
                "feedback" => "It was a cherishing experience. Projects were quite detailed and challenging. Tasks were well defined. Very Professional Guidance and Reviews .The timelines were quite generous and fair. Learned a lot personally to improve(based on feedback) and was delighted to interact with experienced professionals. I Would like to thank all of you for providing me this opportunity. Wishing you very good luck! Pranav"
            ],
            [
                "id" => '4',
                "name" => "Vaatsalya Babbar",
                "feedback" => "This internship has been one of the best experiences I've had both academically and as a person. I was able to interact with one of the best minds in the field of AI and learnt a lot!"
            ],
            [
                "id" => '5',
                "name" => "Aryaman Singh Fauzdar",
                "feedback" => "It has been a great and lovely experience for me. Enjoyed the learning that I got through this well structured program, and got a chance to work on such wonderful projects. Would be delighted to be provided any future opportunities ahead with you. Thank you"
            ],
            [
                "id" => '6',
                "name" => "Kapish Jain",
                "feedback" => "My experience in the virtual internship program at Intel has been exceptional. The onboarding was smooth, and the team's support was consistently present. The variety of projects I worked on and the mentorship I received greatly enhanced my skills and industry knowledge."
            ],
            [
                "id" => '7',
                "name" => "Abhinav bazaru",
                "feedback" => "The Simulated internship program was a rewarding experience to improve my knowledge in different machine learning domains and put my theoretical knowledge to practical use.The platform was well structured and the project coordinators were very helpful and look forward to working on here again"
            ],
            [
                "id" => '8',
                "name" => "Nivedita Tibrewala",
                "feedback" => "I am very thankful for the opportunity that I was given. It was a very helpful program. It helped me a lot as I made three different projects. I also got to learn a lot."
            ],
            [
                "id" => '9',
                "name" => "Srivaths Gondi",
                "feedback" => "This internship period of 4 months was quite insightful, I learned to organize and surpass many hurdles while gathering a simulated industry experience."
            ],
            [
                "id" => '10',
                "name" => "Satyam Kumar",
                "feedback" => "It was really a nice opportunity to gain experience in machine learning projects"
            ]
        ];

        return view('index', compact('projects','testimonials'));
    }

    public function newindex()
    {
        $authStudent = Auth::guard('student')->user();
        $studentId = optional($authStudent)->id;
        $institutionId = optional($authStudent)->institution_id;

        $projects = Cache::remember('projects.index', 60*60, function () use ($studentId, $institutionId) {
            return Project::query()
                ->where('status', 'publish')
                ->where(function($query) use ($studentId, $institutionId) {
                    $query->where('institution_id', $institutionId)
                        ->orWhere('institution_id', null);
                })
                ->whereNotIn('id', function($query) use ($studentId) {
                    $query->select('project_id')
                        ->from('enrolled_projects')
                        ->where('student_id', $studentId);
                })
                ->get();
        });

        return view('newindex', compact('projects'));
    }

}
