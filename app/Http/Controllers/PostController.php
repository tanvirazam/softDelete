<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::get();
        return view('pages.index', [
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        return view('pages.create');
    }

    public function create_store(Request $request)
    {


        $request->validate([
            'title' => 'required|unique:posts|max:255',
            'description' => 'required',
            'category' => 'required',
            'tags' => 'required',
            'status' => 'required',
            'featured_image' => 'required',
        ]);

        if ($request->hasFile('featured_image')) {
            $images = $request->file('featured_image');
            $imageStored = 'post_photo_' . md5(uniqid()) . time() . $images->getClientOriginalExtension();
            $images->move(public_path('images'), $imageStored);
        }

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'tags' => $request->tags,
            'status' => $request->status,
            'featured_image' => $imageStored,
        ]);

        return back()->with('success', 'post created successfully !');
    }

    public function post_show($id)
    {
        $post_id = Post::findOrFail($id);
        return view('pages.show', [
            'post_id' => $post_id,
        ]);

    }

    public function delete($id)
    {
        $post_ids = Post::findOrFail($id);
        $post_ids->delete();

        Toastr::success('Delete successfully done !');
        return redirect()->route('posts.index');
    }

    public function post_edit($id)
    {
        $post_id = Post::findOrFail($id);

        return view('pages.edit', [
            'post_id' => $post_id,
        ]);
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'title' => 'required|unique:posts,title,' . $id . '|max:255',
        //     'description' => 'required',
        //     'category' => 'required',
        //     'tags' => 'required',
        //     'status' => 'required',
        //     'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file validation as needed
        // ]);

        $post = Post::findOrFail($id);

        if ($request->hasFile('featured_image')) {
            // Delete old image if it exists
            if ($post->featured_image && file_exists(public_path('images/' . $post->featured_image))) {
                unlink(public_path('images/' . $post->featured_image));
            }

            $images = $request->file('featured_image');
            $imageStored = 'post_photo_' . md5(uniqid()) . time() . '.' . $images->getClientOriginalExtension();
            $images->move(public_path('images'), $imageStored);

            $post->update([
                'featured_image' => $imageStored,
            ]);
        }

        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'tags' => $request->tags,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Post updated successfully!');
    }

    //soft delete start

    public function softDelete()
    {
        $trasted = Post::onlyTrashed()->get();
        return view('pages.trast', [
            'trasted' => $trasted,
        ]);
    }

    public function forceDelete($id)
    {
        $user_id = Post::onlyTrashed()->findOrFail($id);
        $user_id->forceDelete();
        return back()->with('success', 'permanent deleted success !');
    }

    //restore
    public function restore($id)
    {
        $user_ID = Post::onlyTrashed()->findOrFail($id);
        $user_ID->restore();
        return back()->with('success', 'Restore Successfully Done !');
    }
    //soft delete end
}
