<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\Project::factory(30)->create();
        // \App\Models\ProjectUser::factory(10)->create();
        \App\Models\ProjectUser::factory(10)->create();
        // \App\Models\Friendlist::factory(10)->create();
        // \App\Models\FriendRequest::factory(10)->create();
        // for($i=0;$i<5;$i++){
        //     \App\Models\Task::factory(10)->create();
        // }
        // \App\Models\Attachment::factory(10)->create();
        // \App\Models\Comment::factory(50)->create();

    }
}
