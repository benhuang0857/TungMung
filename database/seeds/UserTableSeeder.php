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
        for($i=0; $i<50; $i++)
        {
            DB::table('users')->insert([
                'name' => str_random(10),
                'email' => str_random(10).'@gmail.com',
                'password' => bcrypt('secret'),
                'employeeid' => uniqid(),
                'dept' => 'ML7A',
                'status' => 'ok',
                'role' => 'normal'
            ]);
        }
    }
}
