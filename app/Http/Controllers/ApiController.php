<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Like;
use App\Friend;
use App\Advertisement;

class ApiController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkheader');
    }



    public function logged_in_user(){
        $logged_in_user = User::find(auth()->user()->id);
        return [
            'id'=>$logged_in_user->id,
            'name'=>$logged_in_user->first_name.' '.$logged_in_user->last_name,
            'image'=> '/storage/profile_images/'.$logged_in_user->profile_image
            ];
    }



    public function posts(){
        $response = array();


        $friends = Friend::where([
            ['user_id','=',auth()->user()->id],
            ['friendship_state','=','friend'],
        ])->pluck('friend_id');

        
        $posts = Post::whereIn('user_id',$friends)
                ->orWhere('user_id',auth()->user()->id)
                ->orWhere('is_public','=', true)
                ->orderBy('updated_at')
                ->get();


        foreach ($posts as $post) {
           array_push($response, [
                'id'=>$post->id,
                'name'=>$post->user->first_name.' '.$post->user->last_name,
                'profile_image'=>'/storage/profile_images/'.$post->user->profile_image,
                'title'=>$post->title,
                'content'=>$post->content,
                'post_image'=>'/storage/post_images/'.$post->post_image,
                'likes'=>count($post->likes),
                'you_liked_it'=>($post->likes->find(auth()->user()->id)  ? true : false),
                // 'post_date'=>($post->updated_at==null ? '-': $post->updated_at->toDateString()),
                //the above line has been replaced because it refers to Gregorian Calender but in the front-end 
                // the Calender is Jalali and it is a pain in the neck to convert this record here
                // so post_date deliberately gets another values about whether the post is pulic or not
                'post_date'=>($post->is_public ? 'انتشار عمومی' : 'انتشار برای دوستان'),
                'yourself'=>($post->user_id == auth()->user()->id ? true : false)
            ]);
        }
        
        
        return $response;
    }




    public function friends(){
        $response = array();
        $friends = User::find(auth()->user()->id)->friends;
        foreach ($friends as $friend) {
            if($friend->pivot->friendship_state == 'friend'){
                array_push($response,[
                        'id'=>$friend->id,
                        'name'=>$friend->first_name.' '.$friend->last_name,
                        'image'=> '/storage/profile_images/'.$friend->profile_image
                ]);
            }
        }
        return $response;
    }



    public function get_friend_requests(){
        $response = array();
        $friends = User::find(auth()->user()->id)->friends;
        foreach ($friends as $friend) {
            if($friend->pivot->friendship_state == 'requested'){
                array_push($response,[
                        'id'=>$friend->id,
                        'name'=>$friend->first_name.' '.$friend->last_name,
                        'image'=> '/storage/profile_images/'.$friend->profile_image
                ]);
            }
        }
        return $response;
    }



    public function advertisements(){
        $response = array();
        $advs = Advertisement::all();
        foreach ($advs as $adv) {
            array_push($response,[
                'id'=>$adv->id,
                'title'=>$adv->title,
                'content'=>$adv->content
            ]);
        }

        return $response;
    }



    public function interested($id){
        $response = array();
        $post = Post::find($id);
            $interested_people = $post->likes;
            foreach ($interested_people as $interested_person) {
                array_push($response, [
                    'name'=>$interested_person->first_name.' '.$interested_person->last_name,
                    'image'=> '/storage/profile_images/'.$interested_person->profile_image
                ]);
            }

            return $response;
       
       
    }


    public function cancel_friendship(Request $request){
        
        Friend::where([
            ['user_id','=',auth()->user()->id],
            ['friend_id','=',$request->input('id')]
        ])
        ->orWhere([
            ['user_id','=',$request->input('id')],
            ['friend_id','=',auth()->user()->id]
        ])
        ->delete();

        return [];
    }



    public function like_post(Request $request){
        $like = new Like;
        $like->user_id = auth()->user()->id;
        $like->post_id = $request->input('id');
        $like->save();
        return [];
    }



    public function unlike_post($id){
        Like::where([
            ['user_id','=',auth()->user()->id],
            ['post_id','=',$id]
        ])
        ->delete();
        return [];
    }



    public function found_users($keyword){
        $response = array();
        $friends = User::find(auth()->user()->id)->friends;
        $users = User::where('first_name','=',$keyword)
        ->orWhere('last_name','=',$keyword)
        ->orderBy('first_name')
        ->get();
        foreach ($users as $user) {
            $friendship_state = 'stranger';
            foreach ($friends as $friend) {
                if($user->id==$friend->id){
                    $friendship_state = $friend->pivot->friendship_state;
                    break;
                }
                 
            }
            if($user->id==auth()->user()->id){
                continue;
            }

            array_push($response, [
                'id'=>$user->id,
                'name'=>$user->first_name.' '.$user->last_name,
                'friendship_state'=> $friendship_state,
                'image'=>'/storage/profile_images/'.$user->profile_image
            ]);
        }

        return $response;
    }




    public function remove_post($id){
        Like::where('post_id','=',$id)
        ->delete();
        $post = Post::find($id);
        Storage::delete('public/post_images/'.$post->post_image);
        $post->delete();
        return [];
    }




    public function change_friend_requests(Request $request){
        if($request->input('friendship_state')=='friend'){
            $friend = Friend::where([
                ['user_id','=',auth()->user()->id],
                ['friend_id','=',$request->input('id')]
                ])
                ->get();
            $friend[0]->friendship_state = 'friend';
            $friend[0]->save();    
            

            $friend = Friend::where([
                ['friend_id','=',auth()->user()->id],
                ['user_id','=',$request->input('id')]
                ])
                ->get();
            $friend[0]->friendship_state = 'friend';
            $friend[0]->save();  
            
        }


        if($request->input('friendship_state')=='stranger'){
            Friend::where([
                ['user_id','=',auth()->user()->id],
                ['friend_id','=',$request->input('id')]
                ])
                ->delete();  
            
            Friend::where([
                ['friend_id','=',auth()->user()->id],
                ['user_id','=',$request->input('id')]
                ])
                ->delete();
        }

        return [];
    }



    public function make_requests(Request $request){
        if($request->input('friendship_state')=='being requested'){
            $friend = new Friend;
            $friend->user_id = auth()->user()->id;
            $friend->friend_id = $request->input('id');
            $friend->friendship_state = 'being requested';
            $friend->save();
            
            $friend = new Friend;
            $friend->friend_id = auth()->user()->id;
            $friend->user_id = $request->input('id');
            $friend->friendship_state = 'requested';
            $friend->save();
           
        }

        if($request->input('friendship_state')=='stranger'){
            Friend::where([
                ['user_id','=',auth()->user()->id],
                ['friend_id','=',$request->input('id')]
                ])
                ->delete();  
            
            Friend::where([
                ['friend_id','=',auth()->user()->id],
                ['user_id','=',$request->input('id')]
                ])
                ->delete();
        }

        return [];
    }

}
