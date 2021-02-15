<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{

        public function run()
        {
            DB::table('langauges')->insert(
                [
                    'language_in_arabic' => "العربية",
                    'language_in_english' => "Arabic",
               ],
               [
                    'language_in_arabic' => "الإنكليزية",
                    'language_in_english' => "English",
                ],
                [
                 'language_in_arabic' => "الكوردية",
                'language_in_english' => "Kurdish",
                ]
        );


        }
}
