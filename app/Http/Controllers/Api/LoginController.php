<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CatgoryList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        
        $rules=[
            'email'=>'required|email',
            'password'=>'required',
        ];
  
       $validator=validator::make($request->all(),$rules);
       if($validator->fails())
        {
            return response()->json($validator->getMessageBag()->all());  
        }
        else
        {
            if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
                $user=User::where('email',$request->email)->first();
                $access_token=Str::random(60);
                User::where('email',$request->email)->update(['remember_token'=>$access_token]);    
                return response()->json([
                    'success'=>true,
                    'message'=>'User Successfully loggedin',
                    'access_token'=>$access_token
                ]);
            }
            else
            {
                return response()->json([
                    'error'=>true,
                    'message'=>'Invlaid email or password!'
                ]);
            }
        }
       //$request->authenticate();

        
        //return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function profileUpdate(Request $request)
    {
        $remember_token = $request->bearerToken();
      
        $profile_data=User::where('remember_token',$remember_token)->first();
        // if(is_null($profile_data))
        // {
        //     return response()->json([
        //         'error'=>true,
        //         'message'=>'Access token does not match',
        //     ]);   
        // }
        $rules=[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            ];
        $validator=validator::make($request->all(),$rules);
        if($validator->fails())
        {
                return response()->json($validator->getMessageBag()->all());  
        }
        //$email_check=User::where('email',$request->email)->first();
        if($request->email == $profile_data->email)
        {
            $profile['name']=$request->name;
            $profile['email']=$request->email;
            $profile['password']=Hash::make($request->password);
            User::where('remember_token',$remember_token)->update($profile);
            return response()->json([
                'success'=>true,
                'message'=>'User updated',
            ]); 
        }
        else
        {
            
            $rules=[
                'email'=>'required|email|unique:users',
                ];
            $validator=validator::make($request->all(),$rules);
            if($validator->fails())
            {
                return response()->json($validator->getMessageBag()->all());  
            }

            $profile['name']=$request->name;
            $profile['email']=$request->email;
            $profile['password']=Hash::make($request->password);
            User::where('remember_token',$remember_token)->update($profile);
            return response()->json([
                'success'=>true,
                'message'=>'User updated',
            ]);  
     
        }
        
    }

    public function register(Request $request)
    {
        $rules=[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required',
        ];

        $validator=validator::make($request->all(),$rules);
        if($validator->fails())
        {
                return response()->json($validator->getMessageBag()->all());  
        }
        else{
            $remember_token=Str::random(60); 
            $all_data=$request->all();
            $all_data['remember_token']=$remember_token;
            $all_data['password']=Hash::make($request->password);
            $user=User::create($all_data);
            
            $CatgoryList=CatgoryList::create([
                'user_id' => $user->id,
                'category_name' => 'Default',
                'is_default' =>'1'
            ]);

            return response()->json([
                        'success'=>true,
                        'message'=>'User created',
                        'data'=>$user,
                        'access_token'=>$remember_token
                ]);

        }
    }
    
    public function logout(Request $request){
        $remember_token = $request->bearerToken();
        
        $data['remember_token']='';
        User::where('remember_token',$remember_token)->update($data);
        
        Auth::logout();
        
        return response()->json([
                'success'=>true,
                'message'=>'Successfully user logout'
        ]);
    }
}
