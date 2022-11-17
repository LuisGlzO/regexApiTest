<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends Controller
{
    //
    public function index(){
        $posts = Post::all();
        return response()->json(compact('posts'));
    }

    public function store(Request $request){
        var_dump($request->image);
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,svg'
        ]);


        $post = $request->all();
        
        if($image = $request->file('image')){
            $routeSaveImg = 'image/';
            $imgName = date('YmdHis') . "_" . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/postImages', $imgName); //ya no lo uso
            $post['image'] = 'storage/postImages/' . $imgName; //hardcodeado
        }
        Post::create($post);
        return response()->json(compact('post'));
    }

    public function show(Post $post){
        return response()->json(compact('post'));
    }

    public function update(Post $post, Request $request){
        $post = $post->update($request->all());
        return response()->json(compact('post'));


    }

    public function destroy(Post $post){
        $post->delete();
        return response()->json(compact('post'));

    }
}
