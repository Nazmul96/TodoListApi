<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LogController extends Controller
{

    public function fromValidation($all_request)
    {
        
        $rules=[
            'client_id'=>'required',
            'category_id'=>'required',
            'subcat_id'=>'required',
            'date'=>'required',
            'time'=>'required',
            'title'=>'required',
            'description'=>'required'
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
        //
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
        $validator=$this->fromValidation($request->all()); 
       
        if($validator->fails())
        {
             return response()->json($validator->getMessageBag()->all());  
        }
 
        $log=Log::create([
                 'client_id' => $request->client_id,
                 'date' => $request->date,
                 'time' => $request->time,
                 'title' => $request->title,
                 'description' => $request->description,
        ]);
 
        return response()->json([
             'success'=>true,
             'message'=>'Log created',
 
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
        $log=Log::find($id);
        if(is_null($log))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Logs not found',
            ]);
        }
        else
        {
            return response()->json([
                'success'=>true,
                'message'=>'Logs found',
                'data'=> $log,
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
        $log=Log::find($id);
        if(is_null($log))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Logs not found',
            ]);
        }
        else
        {
            $validator=$this->fromValidation($request->all());
            if($validator->fails())
            {
                 return response()->json($validator->getMessageBag()->all());  
            }

            $log->update($request->all());
            return response()->json([
                'success'=>true,
                'message'=>'Logs Updated',
                'data'=> $log,
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
        $log=Log::find($id);
        if(is_null($log))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Logs not found',
            ]);
        }
        $log->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Logs Delete',
        ]);
    }
}
