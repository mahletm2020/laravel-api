<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use App\Models\Post;
use App\Models\post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::all();
        return response()->json([
            'status'=>true,
            'message'=>'post reviewed sucessfully',
            'data'=>PostResourse::collection($post)
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|max:255',
            'body' => 'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'All fields are required',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $post = Post::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Post created successfully',
            'data' => new PostResourse($post)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post =Post::find($id);
        if(!$post){
            return response()->json([
                'status'=>false,
                'message'=>'post not found'
            ],404);
        }
        return response()->json([
            'status'=>true,
            'message'=>'post retrived sucessfully ',
            'data' => new PostResourse($post)
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|max:255',
            'body' => 'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'All fields are required',
                'errors' => $validator->errors()
            ], 422);
        }
        $post =Post::find($id);
        
        if(!$post){
            return response()->json([
                'status'=>false,
                'message'=>'post not found'
            ],404);
        }
        $post->update($request->all());

        return response()->json([
            'status'=>true,
            'message'=>'post updated sucessfully ',
            'data' => new PostResourse($post)
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post =Post::find($id);
        
        if(!$post){
            return response()->json([
                'status'=>false,
                'message'=>'post not found'
            ],404);
        }
        $post->delete();

        return response()->json([
            'status'=>true,
            'message'=>'post deleted sucessfully ',
        ],200);
    }
}
