<?php

use Illuminate\Database\Seeder;
use Capello\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Codefy',
            'email' => 'admin@codefy.com.br',
            'password' => bcrypt('codefy'),
            'cpf' => '000.000.000-00',
            'birth' => '2018-01-01',
            'gender' => 'M',
            'access_level' => 5,
        ]);

        User::create([
            'name' => 'Leonardo Theodoro',
            'email' => 'simplespinheiro@gmail.com',
            'password' => bcrypt('leonardo'),
            'cpf' => '459.121.838-40',
            'birth' => '2000-02-02',
            'gender' => 'M',
            'access_level' => 3
        ]);
    }
}
