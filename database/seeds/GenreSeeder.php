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
        $genres = [
            [
                'id' => '1',
                'genre_in_english' => 'Romance',
                'genre_in_arabic' => 'رومانسي'
            ],[
                'id' => '2',
                'genre_in_english' => 'Horror',
                'genre_in_arabic' => 'رعب'
            ],[
                'id' => '3',
                'genre_in_english' => 'Crime',
                'genre_in_arabic' => 'جريمة'
            ],[
                'id' => '4',
                'genre_in_english' => 'Animie',
                'genre_in_arabic' => 'أنيمي'
            ]
        ];

        DB::table('genres')->insert($genres);
    }
}
