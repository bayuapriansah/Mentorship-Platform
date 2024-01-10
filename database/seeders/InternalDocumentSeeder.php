<?php

namespace Database\Seeders;

use App\Models\InternalDocumentGroupSection;
use App\Models\InternalDocumentPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InternalDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InternalDocumentPage::truncate();
        InternalDocumentGroupSection::truncate();

        $sections = [
            ['id' => 1, 'name' => 'Mentorship Program'],
            ['id' => 2, 'name' => 'Skills Track'],
            ['id' => 3, 'name' => 'Entrepreneur Track'],
        ];

        foreach ($sections as $section) {
            InternalDocumentGroupSection::create($section);
        }

        for ($i = 1; $i <= 20; $i++) {
            $title = 'Document #' . $i;

            InternalDocumentPage::create([
                'id' => $i,
                'internal_document_group_section_id' => 1,
                'title' => $title,
                'slug' => Str::slug($title . '-' . $i),
                'subtitle' => 'This is a subtitle',
                'description' => '<p>This is a description</p>',
            ]);
        }
    }
}
