@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
    <!-- Blog Post List -->

    @if (session('success'))
        <div class="alert alert-danger">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between">
        <h3 class="text-xl font-semibold mb-4">Recent Blog Posts</h3>
        <div>
            <a class="btn btn-primary p-2 px-2 bg-indigo-500" href="{{ route('soft-delete') }}">Trasted List</a>
        </div>
    </div>
    <div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Post Title
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tags
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Published Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $post->title }}
                            </th>
                            <td class="px-6 py-4">
                                {{ ucwords($post->category) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ ucwords(implode(', ', $post->tags)) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $post->created_at->format('F, d y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('post.show', $post->id) }}"
                                        class="px-3 py-2 rounded text-gray-100 bg-indigo-500 hover:scale-105 transition focus:outline-none focus:ring focus:border-blue-300 ">
                                        View
                                    </a>
                                    <a href="{{ route('post.edit', $post->id) }}"
                                        class="px-3 py-2 rounded text-gray-100 bg-green-400 hover:scale-105 transition focus:outline-none focus:ring focus:border-blue-300">
                                        Edit
                                    </a>

                                    <form id="postId" action=" {{ route('delete', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-3 py-2 rounded text-gray-100 bg-red-400 hover:scale-105 transition  focus:outline-none focus:ring focus:border-red-500 deletesweetalert">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.querySelector(".deletesweetalert").addEventListener("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('postId').submit();
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                }
            });
        });
    </script>
@endsection
