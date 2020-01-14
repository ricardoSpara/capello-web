<?php

use Illuminate\Database\Seeder;
use Capello\Models\Course;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::create([
            'name' => 'Informática'
        ]);

        Course::create([
            'name' => 'Eletrônica'
        ]);
        
        Course::create([
            'name' => 'Mecânica'
        ]);

        Course::create([
            'name' => 'Ensino médio'
        ]);
    }
}
