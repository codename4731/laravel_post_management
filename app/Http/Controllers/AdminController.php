<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        // Retrieve paginated list of posts
        $posts = Post::paginate(10); // Change the number according to your preference

        // Pass the paginated posts to the view
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file types and size
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/posts', 'public');
            $validatedData['image'] = $imagePath;
        }
        $user_id =  Auth::user()->id;
        $validatedData["user_id"] = $user_id;
        Post::create($validatedData);

        return redirect()->route('admin.posts.index');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file types and size
        ]);

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the previous image if it exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('uploads/posts', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Update the post with the validated data
        $post->update($validatedData);

        return redirect()->route('admin.posts.index');
    }

    public function destroy(Post $post)
    {
        // Delete the image file if it exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        // Delete the post record
        $post->delete();

        // Redirect back to the posts index page with a success message
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
}
