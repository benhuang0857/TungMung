<?php

use Illuminate\Database\Seeder;

class HNO3TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = new DateTime('2021-09-05 00:00');
        for($i=0; $i<300; $i++)
        {
            $time->add(new DateInterval('PT' . 15 . 'M'));
            $stamp = $time->format('Y-m-d H:i:s');
            DB::table('hno3')->insert([
                'capacity' => mt_rand(0, 100),
                'machine_name' => 'HNO3-M-2',
                'location' => 'location_02',
                'created_at' => $stamp
            ]);
        }
    }
}
