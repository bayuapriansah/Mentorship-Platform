<?php

namespace App\Models;

use App\Models\Batch;
use App\Models\Company;
use App\Models\Student;
use App\Models\ProjectSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'problem', 'image', 'batch_id', 'student_id', 'company_id', 'dataset'];
    protected $casts = [
        'dataset' => 'array', // Add this
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function projectSections()
    {
        return $this->hasMany(ProjectSection::class);
    }

    public function mentors()
    {
        return $this->belongsToMany(Mentor::class);
    }

    public function enrolled_project()
    {
        return $this->hasMany(EnrolledProject::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class,'id','project_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function submission($studentId, $projectId)
    {
        // Ambil data submission berdasarkan studentId dan projectId.
        // Saya asumsikan Anda memiliki model Submission dan relasinya sudah didefinisikan.
        $submission = Submission::where('student_id', $studentId)
                                ->where('project_id', $projectId)
                                ->get();

        // Anda bisa memodifikasi kode di atas sesuai dengan struktur dan kebutuhan aplikasi Anda.

        return $submission;
    }

    public function getProjectDomainText()
    {
        switch ($this->project_domain) {
            case 'statistical':
                return 'Machine Learning';

            case 'computer_vision':
                return 'Computer Vision';

            case 'nlp':
                return 'NLP';

            default:
                return $this->project_domain;
        }
    }
}
