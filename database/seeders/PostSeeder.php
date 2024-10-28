<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()->count(25)->create();

        $user = User::where('email', 'test@test.com')->first();
        if($user) {
            Post::factory(5)->draft()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
