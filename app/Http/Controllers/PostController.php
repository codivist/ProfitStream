<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class PostController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a user's list of posts
     */
    public function index()
    {
        return Inertia::render('Posts/Index', [
            'posts' => Post::with('user')
                ->where('user_id', auth()->user()->id)
                ->latest()
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'is_published' => 'boolean',
        ]);

        $post = $request->user()->posts()->create([
            ...$validated,
            'published_at' => $validated['is_published'] ? now() : null,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // check to see if post is draft and if it is not the user's own post
        if ($post->isDraft() && $post->user_id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        return Inertia::render('Posts/Show', [
            'post' => $post->load('user')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('edit', $post);

        return Inertia::render('Posts/Edit', [
            'post' => $post,
            'canEdit' => auth()->user()->can('edit', $post),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'is_published' => 'boolean',
        ]);

        $post->update([
            ...$validated,
            'published_at' => $validated['is_published'] ? now() : null,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }

    /**
     * api call to get all the latest posts
     */
    public function allPosts()
    {
        return Inertia::render('Dashboard', [
            'currentUser' => auth()->user(),
            'posts' => Post::with('user')
                ->published()
                ->latest()
                ->get(),
        ]);
    }

    public function userPosts(User $user)
    {
        return Inertia::render('Posts/UserPosts', [
            'posts' => Post::with('user')
                ->where('user_id', $user->id)
                ->published()
                ->latest()
                ->get(),
            'author' => $user
        ]);
    }

    public function welcome()
    {
        return Inertia::render('Welcome', [
            'posts' => Post::with('user')
                ->published()
                ->latest()
                ->get(),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}
