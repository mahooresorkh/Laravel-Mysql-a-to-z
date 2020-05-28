<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\User;
class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    public function editprofile(){
        $user = User::find(auth()->user()->id);
        return view('profile.editprofile')->with('user',$user);
    }

    public function updateprofile(Request $request){
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'profile_image' => 'image|nullable|max:1999',
            'password' => 'required|string|min:6',
        ]);

        $user = User::find(auth()->user()->id);
        
        if($request->input('password')!==$request->input('password2')){
           return redirect('/editprofile')->with('error','Password confirmation does not match');
        }

        if($request->input('username') !== $user->username){
            $same_username = User::where('username','=',$request->input('username'))->get();
            if(count($same_username)>0){
                return redirect('/editprofile')->with('error','Username is used by someone else.');
            }
        }

        //handle file upload 
        if($request->input('no_image')==1){
            $fileNameToStore = 'noimage.jpg';
        }
        else if($request->hasFile('profile_image')){
            $fileNameWithExt = $request->file('profile_image')->getClientOriginalName();
            
            //get file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('profile_image')->getClientOriginalExtension();

            //Filename to store 
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            //Upload Image
            $path = $request->file('profile_image')->storeAs('public/profile_images',$fileNameToStore);

        }
        else{
            $fileNameToStore = null;
        }

        

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        if($fileNameToStore){
            $profile_image = $user->profile_image;
                
            if($profile_image!=='noimage.jpg'){
                Storage::delete('public/profile_images/'.$profile_image);
            }

            
            $user->profile_image = $fileNameToStore;

        }
        $user->save();
        return redirect('/');
        
    }
}
