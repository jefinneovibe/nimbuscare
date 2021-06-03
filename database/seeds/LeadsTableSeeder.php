<?php

use Illuminate\Database\Seeder;

class LeadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $connection = 'mongodb';
    public function run()
    {
        $user = factory(App\LeadDetails::class, 5000)->create();//
    }
}
