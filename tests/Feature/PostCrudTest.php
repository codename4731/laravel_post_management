<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PostCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanCreatePost()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->post('/admin/posts', [
            'title' => 'Test Post',
            'content' => 'Test content',
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'content' => 'Test content',
            'user_id' => $user->id,
        ]);
    }

    public function testUserCanViewPost()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->get('/admin/posts/' . $post->id);

        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSee($post->content);
    }

    public function testUserCanUpdatePost()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $post = Post::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->put('/admin/posts/' . $post->id, [
            'title' => 'Updated Post',
            'content' => 'Updated content',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Post',
            'content' => 'Updated content',
        ]);
    }

    public function testUserCanDeletePost()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete('/admin/posts/' . $post->id);

        $response->assertStatus(302);
        $this->assertDeleted($post);
    }
}
