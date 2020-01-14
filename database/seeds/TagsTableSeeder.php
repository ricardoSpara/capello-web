<?php

use Illuminate\Database\Seeder;
use Capello\Models\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create([
            'course_id' => 1,
            'name' => 'PHP',
            'user_id' => 1
        ]);
        Tag::create([
            'course_id' => 1,
            'name' => 'Aplicativos',
            'user_id' => 1
        ]);
        Tag::create([
            'course_id' => 2,
            'name' => 'Arduino',
            'user_id' => 1
        ]);
        Tag::create([
            'course_id' => 2,
            'name' => 'Telecomunicações',
            'user_id' => 1
        ]);
        Tag::create([
            'course_id' => 3,
            'name' => 'Motores',
            'user_id' => 1
        ]);
        Tag::create([
            'course_id' => 3,
            'name' => 'CNC',
            'user_id' => 1
        ]);
    }
}
