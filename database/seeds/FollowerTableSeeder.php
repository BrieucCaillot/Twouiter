<?php

use Illuminate\Database\Seeder;

class FollowerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Follower::class, 10)->create();
    }
}
