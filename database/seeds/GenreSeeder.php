<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->insert(
            [
              'genre_in_english' => 'Romance',
              'genre_in_arabic' => 'رومانسي'
            ],[
              'genre_in_english' => 'Horror',
              'genre_in_arabic' => 'رعب'
            ],[
              'genre_in_english' => 'Crime',
              'genre_in_arabic' => 'جريمة'
            ],[
              'genre_in_english' => 'Animie',
              'genre_in_arabic' => 'أنيمي'
            ]
    );
    }
}
