<?php

use App\Models\Post;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostFormValidationTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testAdminUserCanCreatePost()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($adminUser)->post('/admin/posts', [
            'title' => 'Test title',
            'content' => 'Test content',
        ]);

        $response->assertSessionDoesntHaveErrors(['title', 'content']);
        $response->assertRedirect(); // Assuming successful creation redirects somewhere
    }

    public function testAdminUserCanUpdatePost()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $post = Post::factory()->create();

        $response = $this->actingAs($adminUser)->put("/admin/posts/{$post->id}", [
            'title' => 'Updated title',
            'content' => 'Updated content',
        ]);

        $response->assertSessionDoesntHaveErrors(['title', 'content']);
        $response->assertRedirect(); // Assuming successful update redirects somewhere
    }

    public function testAdminUserCanViewPost()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $post = Post::factory()->create();

        $response = $this->actingAs($adminUser)->get("/admin/posts/{$post->id}");

        $response->assertStatus(200);
    }

    public function testAdminUserCanDeletePost()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $post = Post::factory()->create();

        $response = $this->actingAs($adminUser)->delete("/admin/posts/{$post->id}");

        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect(); // Assuming successful deletion redirects somewhere
    }

    public function testAdminUserCanViewAllPosts()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $posts = Post::factory(5)->create();

        $response = $this->actingAs($adminUser)->get('/admin/posts');

        $response->assertStatus(200);
    }
}
