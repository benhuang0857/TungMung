<?php

use Illuminate\Database\Seeder;

class BrushRollerElectricitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = new DateTime('2021-07-29 00:00');
        for($i=0; $i<200; $i++)
        {
            $time->add(new DateInterval('PT' . 15 . 'M'));
            $stamp = $time->format('Y-m-d H:i:s');
            DB::table('brush_roller_electricity')->insert([
                'capacity' => mt_rand(0, 100),
                'factory_name' => 'ML7AD1',
                'type' => 'realtime',
                'created_at' => $stamp
            ]);
        }
    }
}
