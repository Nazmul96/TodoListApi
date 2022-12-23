<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClientController extends Controller
{

    public function fromValidation($all_request)
    {
        $rules=[
            'name'=>'required',
            'email'=>'required|email',
            'gender'=>'required',
            'date_of_birth'=>'required',
       ];

       $validator=validator::make($all_request,$rules);

       return  $validator;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'success'=>true,
            'message'=>'Clients found',
            'data'=> Client::all(),
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
  
        // $remember_token=$request->header('accesstoken');
        // $data=User::where('remember_token',$remember_token)->first();

        // if(is_null($data))
        // {
        //     return response()->json([
        //         'error'=>true,
        //         'message'=>'Access token does not match',
        //     ]);   
        // }   
       $validator=$this->fromValidation($request->all()); 
       
       if($validator->fails())
       {
            return response()->json($validator->getMessageBag()->all());  
       }

       $client=Client::create([
                'name' => $request->name,
                'email' => $request->email,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
       ]);

       return response()->json([
            'success'=>true,
            'message'=>'Client created',

       ]);

       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client=Client::find($id);
        if(is_null($client))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Clients not found',
            ]);
        }
        else
        {
            return response()->json([
                'success'=>true,
                'message'=>'Clients found',
                'data'=> $client,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        // $remember_token=$request->header('accesstoken');
        // $data=User::where('remember_token',$remember_token)->first();

        // if(is_null($data))
        // {
        //     return response()->json([
        //         'error'=>true,
        //         'message'=>'Access token does not match',
        //     ]);   
        // }
 
        $client=Client::find($id);
        if(is_null($client))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Clients not found',
            ]);
        }
        else
        {
            $validator=$this->fromValidation($request->all());
            if($validator->fails())
            {
                 return response()->json($validator->getMessageBag()->all());  
            }

            $client->update($request->all());
            return response()->json([
                'success'=>true,
                'message'=>'Clients Updated',
                'data'=> $client,
            ]);
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     
        $client=Client::find($id);
        if(is_null($client))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Clients not found',
            ]);
        }
        $client->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Clients Delete',
        ]);
    }

    
}
