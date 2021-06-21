<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = Post::all();
        //$posts = Post::where('title','!=','')->orderBy('created_at','desc')->get();
        //dd($posts);
        //$posts = DB::table('users')
            //->leftJoin('posts', 'users.id', '=', 'posts.user_id')
            //->get();
        $user = User::find(Auth::id()); 
        $posts = $user->posts()->orderBy('created_at','desc')->get();
        $count = $user->posts()->where('title','!=','')->count();
        //$count = Post::where('title','!=','')->count();
        return view('posts.index', compact('posts', 'count'));
        //return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:posts|max:255',
            'description' => 'required'
        ]);
        
        if($request->hasFile('img')){

            $filenameWithExt = $request->file('img')->getClientOriginalName();

            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            $extension = $request->file('img')->getClientOriginalExtension();

            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            $path = $request->file('img')->storeAs('public/img', $fileNameToStore);
        } else{
            $fileNameToStore = '';
        }

        $posts = new Post();
        $posts->fill($request->all());
        $posts->img = $fileNameToStore;
        $posts->user_id = auth()->user()->id;
        if($posts->save()){
            $message = "Successfully save";
        }

        return redirect('/posts')->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {    
        $posts = Post::find($post->id);
        $comments = $post->comments;
        return view('posts.show', compact('post', 'comments'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:posts|max:255',
            'description' => 'required'
        ]);
        
        $posts = Post::find($id);
        $posts->fill($request->all());
        $posts->user_id = auth()->user()->id;
        $posts->save();

        return redirect('/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $posts = Post::find($id);
        $posts->delete();

        return redirect('/posts');
    }

    public function deleteBlank()
    {
        $delete = Post::where('title','=','')->delete();

        return redirect('/posts');
    }

    public function archive()
    {
        $posts = Post::onlyTrashed()->get();
        //dd($posts);
        return view('posts.archive',compact('posts'));
    }

    public function restore($id)
    {
        $posts = Post::withTrashed()->find($id)->restore();
        
        return redirect('/posts');
    }
}
