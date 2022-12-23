<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\CatgoryList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class DashboardController extends Controller
{
    public function dashboardData(Request $request){
        
        $query=Task::Query();
        $today_date=date('Y-m-d');
        $query->where('due_date','>=',$today_date);
        $task_list=$query->with('category')->get()->toArray();
        
        $token = $request->bearerToken();
        $user=User::where('remember_token',$token)->first();
        
        $complete_task=Task::where('user_id',$user->id)->where('status',3)->get()->count();
        $pending_task=Task::where('user_id',$user->id)->where('status','!=',3)->get()->count();
        $overdue_task=Task::where('user_id',$user->id)->where('due_date','<=',$today_date)->where('status','!=',3)->get()->count();
        $total_task=Task::get()->count();
        
        $data['task_list']=$task_list;
        $data['complete_task']=$complete_task;
        $data['pending_task']=$pending_task;
        $data['overdue_task']=$overdue_task;
        $data['total_task']=$total_task;
        
        
        return response()->json([
            'success'=>true,
            'message'=>'Upcoming task found',
            'data'=>$data,
        ]);
    }
}
