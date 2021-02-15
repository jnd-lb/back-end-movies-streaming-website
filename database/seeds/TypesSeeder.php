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
        DB::table('types')->insert(
            [
              'type_in_arabic' => 'Serie'
              'type_in_english' => 'مسلسل'
            ],[
              'type_in_arabic' => 'Tv Show'
              'type_in_english' => 'برنامج تلفزيوني'
            ],[
              'type_in_arabic' => "Movie"
              'type_in_english' => 'فيلم'
            ]
    );
    }
}
