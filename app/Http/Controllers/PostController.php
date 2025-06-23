<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;


class PostController extends Controller
{

    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use \Illuminate\Foundation\Validation\ValidatesRequests;

    public function index()
    {
        $posts = Post::with('user:id,name,email,avatar')->get();
        return response()->json($posts);
    }

    public function store(StorePostRequest $request)
    {
        $post = $request->user()->posts()->create($request->validated());
        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return response()->json($post->load('user:id,name,email,avatar'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {


        $this->authorize('update', $post); // cheching user is able to autherize for update

        $post->update($request->validated());

        return response()->json(
            [
                'message' => 'Post updated successfully',
                'data' => $post
            ], 200);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);  // cheching user is able to autherize for delete

        $post->delete();  // delete post

        return response()->json(
            [
                'message' => 'Post deleted successfully'
            ], 200);
    }
}