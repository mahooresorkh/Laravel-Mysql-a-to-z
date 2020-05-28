<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Post;
class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createpost()
    { 
        
        return view('post.createpost');
    }

    public function storepost(Request $request){

        $this->validate($request, [
            'title'=> 'required',
            'content'=> 'required',
            'post_image' => 'image|nullable|max:1999'
        ]);

        //handle file upload 
        if($request->hasFile('post_image')){
            $fileNameWithExt = $request->file('post_image')->getClientOriginalName();
            
            //get file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('post_image')->getClientOriginalExtension();

            //Filename to store 
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            //Upload Image
            $path = $request->file('post_image')->storeAs('public/post_images',$fileNameToStore);

        }

        else{
            $fileNameToStore = 'noimage.jpg';
        }

        $post = new Post;
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->user_id = auth()->user()->id;
        $post->post_image = $fileNameToStore;
        $post->is_public = $request->input('is_public') == '1' ? true : false;
        $post->save();
        return redirect('/');
    }

    public function editpost($id){ 
        $post = Post::where([
            ['user_id','=',auth()->user()->id],
            ['id','=',$id]
            ])->get();
        
        if(count($post)==1){
            return view('post.editpost')->with('post',$post[0]);
        }   
        else{
            return redirect('/error-id');
        } 
    }

    public function updatepost(Request $request,$id){
        $this->validate($request, [
            'title'=> 'required',
            'content'=> 'required',
            'post_image' => 'image|nullable|max:1999'
        ]);
        
        //handle file upload 
        if($request->input('no_image')==1){
            $fileNameToStore = 'noimage.jpg';
        }
        else if($request->hasFile('post_image')){
            $fileNameWithExt = $request->file('post_image')->getClientOriginalName();
            
            //get file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('post_image')->getClientOriginalExtension();

            //Filename to store 
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            //Upload Image
            $path = $request->file('post_image')->storeAs('public/post_images',$fileNameToStore);

        }
        else{
            $fileNameToStore = null;
        }

        $post = Post::where([
            ['user_id','=',auth()->user()->id],
            ['id','=',$id]
            ])->get();

        if(count($post)==1){    
            $post[0]->title = $request->input('title');
            $post[0]->content = $request->input('content');
            if($fileNameToStore){
                $post_image = $post[0]->post_image;

                if($post_image!=='noimage.jpg'){
                    Storage::delete('public/post_images/'.$post_image);
                }

                $post[0]->post_image = $fileNameToStore;
            }
            $post[0]->is_public = $request->input('is_public') == '1' ? true : false;
            $post[0]->save();
            return redirect('/');
        }
        else {
            return redirect('/id-error');
        }

    }

    



}
