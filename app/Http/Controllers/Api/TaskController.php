<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;


class TaskController extends Controller
{

    public function fromValidation($all_request)
    {
        $rules=[
            'category_id'=>'required',
            'task_title'=>'required',
            'due_date'=>'required',
            'time_set'=>'required',
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
        $query=Task::Query();

        $perpage=10;
        $page=$request->input('page',1);
        $total=$query->count();
        
        if(!is_null($request->status))
        {   
            $query->where('status',$request->all('status'));
        }

         $token = $request->bearerToken();
         $user=User::where('remember_token',$token)->first();
         //$todo=$query->offset(($page-1) * $perpage)->limit($perpage)->get()->toArray();
        $query->where('user_id',$user->id);
        $task=$query->with('CatgoryList')->get()->toArray();
        if(empty($task))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Task not found',
            ]);
        }
        return response()->json([
            'success'=>true,
            'message'=>'Task found',
            'data'=>$task,
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
        $request_data=$request->all();
        $validator=$this->fromValidation($request->all());
        if($validator->fails())
        {
             return response()->json([
                    'error'=>true,
                    'message'=>$validator->getMessageBag()->all()
             ]);  
        }

        $token = $request->bearerToken();
        $user=User::where('remember_token',$token)->first();
        

        $request_data['user_id']= $user->id;
        $task=Task::create($request_data);
        
        return response()->json([
            'success'=>true,
            'message'=>'Task created',
            'data'=>$token

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
        $task=Task::with('category')->find($id);
        if(is_null($task))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Task not found',
            ]);
        }
        else
        {
            return response()->json([
                'success'=>true,
                'message'=>'Task found',
                'data'=> $task,
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
        $task=Task::find($id);
        if(is_null($task))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Task not found',
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
      
            $request_data=$request->all();

            $task->update($request_data);
            return response()->json([
                'success'=>true,
                'message'=>'Todo Updated',
                'data'=> $task,
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
        $task=Task::find($id);
        if(is_null($task))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Task not found',
            ]);
        }
        $task->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Task Delete',
        ]);
    }

    public function taskUpdate($id,$status)
    {
        if(($status == '3') || ($status == '4'))
        {
            Task::where('id',$id)->update(['status'=>$status]);    
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
    
    public function taskDuplicate($id){
          $copy_data=Task::find($id);
          if(is_null($copy_data))
          {
                return response()->json([
                    'error'=>true,
                    'message'=>'Task not found',
                ]);
          }
          
        $client=Task::create([
                'task_title' => $copy_data->task_title,
                'category_id'=>$copy_data->category_id,
                'due_date'=>$copy_data->due_date,
                'time_set'=>$copy_data->time_set,
                'repeat'=>$copy_data->repeat,
                'status'=>$copy_data->status
       ]);

       return response()->json([
            'success'=>true,
            'message'=>'Task Duplicated',

       ]);
    }
    
  public function taskToday(Request $request){
      
        $query=Task::Query();

        //$perpage=10;
        //$page=$request->input('page',1);
        //$total=$query->count();
        
        if(!is_null($request->status))
        {   
            $query->where('status',$request->all('status'));
        }
        
        $today_date=date('Y-m-d');
        
        //$todo=$query->offset(($page-1) * $perpage)->limit($perpage)->get()->toArray();
        $token = $request->bearerToken();
        $user=User::where('remember_token',$token)->first();
        $query->where('due_date',$today_date)->where('user_id',$user->id);
        $task=$query->with('CatgoryList')->get()->toArray();
        if(empty($task))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Today Task not found',
            ]);
        }
        return response()->json([
            'success'=>true,
            'message'=>'Today task found',
            'data'=>$task,
        ]);
  }
  
  public function taskUpcoming(Request $request){
       $query=Task::Query();

        //$perpage=10;
        //$page=$request->input('page',1);
        //$total=$query->count();
        
        if(!is_null($request->status))
        {   
            $query->where('status',$request->all('status'));
        }
        
        $today_date=date('Y-m-d');
        
        //$todo=$query->offset(($page-1) * $perpage)->limit($perpage)->get()->toArray();
        $token = $request->bearerToken();
        $user=User::where('remember_token',$token)->first();
        
        $query->where('due_date','>=',$today_date)->where('user_id',$user->id);
        $task=$query->with('CatgoryList')->get()->toArray();
        if(empty($task))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Upcoming Task not found',
            ]);
        }
        
        return response()->json([
            'success'=>true,
            'message'=>'Upcoming task found',
            'data'=>$task,
        ]);
   }
   
   public function completeTask($slug){
       dd($slug);
   }
  
  
}
