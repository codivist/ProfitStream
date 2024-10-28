<?php

use App\Models\Post;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

beforeEach(function () {
    $this->user = User::factory()->create();
});

uses(
    Tests\TestCase::class,
    RefreshDatabase::class,
)->in('Feature');

test('guests cannot create posts', function () {
    $response = $this->get(route('posts.create'));
    $response->assertRedirect(route('login'));

    $response = $this->post(route('posts.store'), [
        'title' => 'Test Post',
        'body' => 'Test body',
        'is_published' => true,
    ]);
    $response->assertRedirect(route('login'));
});

test('authenticated users can view the create post form', function () {
    $response = $this->actingAs($this->user)
        ->get(route('posts.create'));

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Posts/Create')
    );
});

test('users can create a published post', function () {
    $postData = [
        'title' => 'My New Post',
        'body' => 'This is the post content.',
        'is_published' => true,
    ];

    $response = $this->actingAs($this->user)
        ->post(route('posts.store'), $postData);

    $response->assertRedirect(route('posts.index'));
    $response->assertSessionHas('success', 'Post created successfully');

    $this->assertDatabaseHas('posts', [
        'title' => 'My New Post',
        'body' => 'This is the post content.',
        'user_id' => $this->user->id,
        'is_published' => true,
    ]);

    $post = Post::latest()->first();
    expect($post->published_at)->not->toBeNull();
});

test('users can create a draft post', function () {
    $postData = [
        'title' => 'Draft Post',
        'body' => 'This is a draft.',
        'is_published' => false,
    ];

    $response = $this->actingAs($this->user)
        ->post(route('posts.store'), $postData);

    $this->assertDatabaseHas('posts', [
        'title' => 'Draft Post',
        'body' => 'This is a draft.',
        'user_id' => $this->user->id,
        'is_published' => false,
    ]);

    $post = Post::latest()->first();
    expect($post->published_at)->toBeNull();
});

test('post requires a title', function () {
    $response = $this->actingAs($this->user)
        ->post(route('posts.store'), [
            'title' => '',
            'body' => 'Test body',
            'is_published' => true,
        ]);

    $response->assertSessionHasErrors(['title']);
});

test('post requires a body', function () {
    $response = $this->actingAs($this->user)
        ->post(route('posts.store'), [
            'title' => 'Test Title',
            'body' => '',
            'is_published' => true,
        ]);

    $response->assertSessionHasErrors(['body']);
});

test('title cannot exceed 255 characters', function () {
    $response = $this->actingAs($this->user)
        ->post(route('posts.store'), [
            'title' => str_repeat('a', 256),
            'body' => 'Test body',
            'is_published' => true,
        ]);

    $response->assertSessionHasErrors(['title']);
});

test('followers are notified when a published post is created', function () {
    Notification::fake();

    $follower = User::factory()->create();
    $this->user->followers()->attach($follower);

    $response = $this->actingAs($this->user)
        ->post(route('posts.store'), [
            'title' => 'New Post',
            'body' => 'Test body',
            'is_published' => true,
        ]);

    Notification::assertSentTo(
        $follower,
        \App\Notifications\NewPostNotification::class,
        function ($notification) {
            return $notification->post->title === 'New Post';
        }
    );
});

test('followers are not notified when a draft post is created', function () {
    Notification::fake();

    $follower = User::factory()->create();
    $this->user->followers()->attach($follower);

    $response = $this->actingAs($this->user)
        ->post(route('posts.store'), [
            'title' => 'Draft Post',
            'body' => 'Test body',
            'is_published' => false,
        ]);

    Notification::assertNothingSent();
});

expect()->extend('toBePublished', function () {
    expect($this->value->published_at)->not->toBeNull();
    expect($this->value->is_published)->toBeTrue();
    return $this;
});

expect()->extend('toBeDraft', function () {
    expect($this->value->published_at)->toBeNull();
    expect($this->value->is_published)->toBeFalse();
    return $this;
});
