<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faqs = [
            [
                'id' => 1,
                'question_ar' => 'هل يمكنني بيع سياراتي',
                'question_en' =>'would I sell my car?',
                'answer_ar' => 'نعم',
                'answer_en' => 'yes'
            ],
            [
                'id' => 2,
                'question_ar' => 'هل يمكنني بيع سياراتي',
                'question_en' =>'would I sell my car?',
                'answer_ar' => 'نعم',
                'answer_en' => 'yes'
            ]
        ];

        foreach ($faqs as $faq)
        {
            Faq::create($faq);
        }
    }
}
