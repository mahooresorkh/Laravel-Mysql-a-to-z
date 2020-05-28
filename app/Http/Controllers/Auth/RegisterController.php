<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    // this is for catching the request method from register form 
    protected $request = null;

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'profile_image' => 'image|nullable|max:1999',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //the boiler plate of image file process and store

        if($this->request->hasFile('profile_image')){
            $fileNameWithExt = $this->request->file('profile_image')->getClientOriginalName();
            
            //get file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            //get file extension
            $extension = $this->request->file('profile_image')->getClientOriginalExtension();

            //Filename to store 
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            //Upload Image
            $path = $this->request->file('profile_image')->storeAs('public/profile_images',$fileNameToStore);

        }


        else{
            $fileNameToStore = 'noimage.jpg';
        }

        // end of boiler palte


        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'profile_image' => $fileNameToStore,
            'password' => bcrypt($data['password']),
        ]);
    }
}
