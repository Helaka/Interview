<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\User;
use Auth;

class AuthController extends Controller
{
    //

    public function login(Request $request){

        $creds = $request->only(['email', 'password']);

        // $token = auth()->guard('api')->attempt($creds);

        if(!$token = auth()->guard('api')->attempt($creds)){

            return response()->json([
                    'sucess'=> false
            ]);
        }

        return response()->json([

            'sucess'=> true,
            'token'=>$token,
            'user'=>Auth::user()
        ]);
    }

    public function register(Request $request){

        $encryptedPass =  Hash::make($request->password);


        $user = new User;

        try{
                $user->email = $request->email;
                $user->password =$encryptedPass;
                $user->phone_number = $request->phone_number;
                $user->token = $request->token;

       
                $user->save();
                return $this->login($request);
        }
        catch(Exception $e){


            return response()->json([

                'sucess'=> false,
                'message'=> $e
            ]);
        }
    }

    public function saveUserInfnfo(Request $request){

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $photo = '';

        if($request->photo!= ''){

            $photo = time().'.jpg';
            file_put_contents('storage/profiles/'.$photo, base64_decode($request->photo));
            $user->photo = $photo;
        }

        $user->update();

            return response()->json([

                'success'=>true,
                'photo'=> $photo 

            ]);

    }

    public function users(){

        $users = User::all();

        return response()->json([

            'success'=>true,
            'user'=>$users

        ]);
    }
}
