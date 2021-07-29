<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$AAJR8oiG9XpzEwa2W/TcGutvOwdB.CNUGCxZKvDenrZJWarD4RPla',
            'employeeid' => uniqid(),
            'dept' => 'ML7A'.mt_rand(1,5),
            'status' => 'ok',
            'role' => 'normal'
        ]);

        for($i=0; $i<50; $i++)
        {
            DB::table('users')->insert([
                'name' => str_random(10),
                'email' => str_random(10).'@gmail.com',
                'password' => bcrypt('secret'),
                'employeeid' => uniqid(),
                'dept' => 'ML7A'.mt_rand(1,5),
                'status' => 'ok',
                'role' => 'normal'
            ]);
        }
    }
}
