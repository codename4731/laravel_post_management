<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NormalUserAccessTest extends TestCase
{
    use RefreshDatabase;

    public function testNormalUserCanViewPosts()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/posts');

        $response->assertStatus(200);
    }

    public function testUserCanViewPost()
    {
        $user = User::factory()->create(['role' => 'user']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->get('/posts/' . $post->id);

        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSee($post->content);
    }

    public function testNormalUserCannotAccessAdminRoutes()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/posts');

        $response->assertStatus(403);
    }
}
