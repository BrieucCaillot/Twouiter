<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create()->each(function ($user) {
            foreach (range(1, 3) as $i) {
                $user->posts()->save(factory(App\Post::class)->make());
            }
        });
    }
}
