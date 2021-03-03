<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'type_in_english' => 'Serie',
                'type_in_arabic' => 'مسلسل'
            ],[
                'type_in_english' => 'Tv Show',
                'type_in_arabic' => 'برنامج تلفزيوني'
            ],[
                'type_in_english' => "Movie",
                'type_in_arabic' => 'فيلم'
            ]
        ];
        DB::table('types')->insert($types);
    }
}
