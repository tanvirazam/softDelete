@extends('layouts.app')

@section('content')
    <!-- Blog Post List -->
    <h3 class="text-xl font-semibold mb-4">Single Blog Post</h3>
    <div>
        <div class="flex justify-end items-center space-x-4 mb-3">
            <a href="{{ route('posts.index') }}"
                class="px-3 py-2 rounded text-gray-100 bg-green-500 hover:scale-105 transition">&lt; Back to All
                Posts</a>

        </div>

        <div>
            <img src="{{ asset('images/' . $post_id->featured_image) }}" alt="Featured Image" class="w-full h-96 object-fill">
        </div>

        <div class="mt-4">
            <h1 class="text-3xl font-semibold"></h1>
            <p class="text-gray-500 py-3">Published On: {{ $post_id->created_at->format('F, d y') }}</p>
            <strong class="text-green-400">Category: {{ $post_id->category }}</strong><span></span>
            <br>
            <strong class="text-green-400">Tags: {{ ucwords(implode(', ', $post_id->tags)) }}</strong><span></span>
            <p class="mt-4">{{ $post_id->description }}</p>
        </div>
    </div>
@endsection
