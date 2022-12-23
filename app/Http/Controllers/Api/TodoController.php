<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Todo;

use function PHPUnit\Framework\isNull;

class TodoController extends Controller
{
    public function fromValidation($all_request)
    {
        $rules=[
            'category_id'=>'required',
            //'subcat_id'=>'required',
            'title'=>'required',
            'description'=>'required',
            'start_time'=>'required',
       ];

       $validator=validator::make($all_request,$rules);

       return  $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request->all('status'));
        $query=Todo::Query();

        $perpage=10;
        $page=$request->input('page',1);
        $total=$query->count();
        
        if(!is_null($request->status))
        {   
            $query->where('status',$request->all('status'));
        }

        //$todo=$query->offset(($page-1) * $perpage)->limit($perpage)->get()->toArray();
        $todo=$query->get()->toArray();
        if(empty($todo))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Todo not found',
            ]);
        }
        return response()->json([
            'success'=>true,
            'message'=>'Todo found',
            'data'=>$todo,
            'total'=>$total,
            'page'=>$page,
            'last_page'=>ceil($total/$perpage)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request_data=$request->all();
        $validator=$this->fromValidation($request->all());
        if($validator->fails())
        {
             return response()->json([
                    'error'=>true,
                    'message'=>$validator->getMessageBag()->all()
             ]);  
        }

        if($request_data['quick_log'] == true){
            $request_data['quick_log']=1;   
        }
        else
        {
            $request_data['quick_log']=0;
        }

        if($request_data['second_signature'] == true){
            $request_data['second_signature']=1;   
        }
        else
        {
            $request_data['second_signature']=0;
        }


        $todo=Todo::create($request_data);
        
        return response()->json([
            'success'=>true,
            'message'=>'Todo created',
            'data'=>$todo
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
        //die($id);
        $Todo=Todo::with('category','subcategory')->find($id);
        if(is_null($Todo))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Todo not found',
            ]);
        }
        else
        {
            return response()->json([
                'success'=>true,
                'message'=>'Todo found',
                'data'=> $Todo,
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
    
        $todo=Todo::find($id);
        if(is_null($todo))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Todo not found',
            ]);
        }
        else
        {
            
            $validator=$this->fromValidation($request->all());
            if($validator->fails())
            {
                return response()->json([
                    'error'=>true,
                    'message'=>$validator->getMessageBag()->all()
                ]);   
            }
            // //echo $request->status;die();
            // if(($request->status == '3') || ($request->status == '4'))
            // {
            //     $todo->update($request->all());
            //     return response()->json([
            //         'success'=>true,
            //         'message'=>'Todo Updated',
            //         'data'=> $todo,
            //     ]);
            // }
            // return response()->json([
            //     'error'=>true,
            //     'message'=>'This status is not correct',
            // ]);
            $request_data=$request->all();
            if($request_data['quick_log'] == true){
                 $request_data['quick_log']=1;   
            }
            else
            {
                $request_data['quick_log']=0;
            }

            if($request_data['second_signature'] == true){
                $request_data['second_signature']=1;   
            }
            else
            {
                $request_data['second_signature']=0;
            }

            $todo->update($request_data);
            return response()->json([
                'success'=>true,
                'message'=>'Todo Updated',
                'data'=> $todo,
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
        $todo=Todo::find($id);
        if(is_null($todo))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Todo not found',
            ]);
        }
        $todo->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Todo Delete',
        ]);
    }

    public function todoUpdate($id,$status)
    {
        if(($status == '3') || ($status == '4'))
        {
            Todo::where('id',$id)->update(['status'=>$status]);    
            return response()->json([
                'success'=>true,
                'message'=>'Successfully updated',
            ]); 
        }

        return response()->json([
            'error'=>true,
            'message'=>'This status is not correct',
        ]);
       
    }
}
