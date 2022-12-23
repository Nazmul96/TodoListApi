<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\CatgoryList;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DB;

class CategoryListController extends Controller
{
    public function fromValidation($all_request)
    {
        $rules=[

            'category_name'=>'required',
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
        $active=0;
        $expired=0;
        $complete=0;
        $delete=0;
        $default=0;
        
        $token = $request->bearerToken();
        $user=User::where('remember_token',$token)->first();
        $CatgoryList=CatgoryList::withCount('Task')->with('Task')->where('user_id',$user->id)->get()->makeHidden(['created_at','updated_at'])->toArray();
      
         if(empty($CatgoryList))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Category not found',
            ]);
        }
        foreach($CatgoryList as $key=>$rows){

              if(!empty($rows['task'])){ 
                     foreach($rows['task'] as $tasks){
                         if($tasks['status'] == 1){
                            $active++;
                         }
                         if($tasks['status'] == 2){
                            $expired++;
                         }
                         if($tasks['status'] == 3){
                            $complete++;
                         }
                         if($tasks['status'] == 4){
                            $delete++;
                         }
                         if($tasks['status'] == 4){
                            $delete++;
                         }
                         if($tasks['status'] == 0){
                            $default++;
                         }
                     } 
             
                
                //$active=0;
                //$expired=0;
               // $complete=0;
               // $delete=0;
               // $default=0;
              }
        }

        //$CatgoryList['active']=$active;
        //$CatgoryList['expired']=$expired;
        //$CatgoryList['complete']=$complete;
        //$CatgoryList['delete']=$delete;
       // $CatgoryList['default']=$default;
        
        return response()->json([
            'success'=>true,
            'message'=>'Category found',
            'data'=> $CatgoryList,
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
 
       $CategoryList=CatgoryList::create([
            'user_id' => $user->id,
            'category_name' =>$request->category_name
       ]);
       return response()->json([
           'success'=>true,
           'message'=>'Category created',
           'data'=>$CategoryList
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
        $CatgoryList=CatgoryList::find($id);
        if(is_null($CatgoryList))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Category not found',
            ]);
        }
        else
        {
            return response()->json([
                'success'=>true,
                'message'=>'Clients found',
                'data'=> $CatgoryList,
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
        $CatgoryList=CatgoryList::find($id);
        if(is_null($CatgoryList))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Category not found',
            ]);
        }
        else
        {
            $validator=$this->fromValidation($request->all());
            if($validator->fails())
            {
                 return response()->json($validator->getMessageBag()->all());  
            }

            $CatgoryList->update($request->all());
            return response()->json([
                'success'=>true,
                'message'=>'Category Updated',
                'data'=> $CatgoryList,
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
        $CatgoryList=CatgoryList::find($id);
        if(is_null($CatgoryList))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Category not found',
            ]);
        }
        if($CatgoryList->is_default == '1'){
            return response()->json([
                'error'=>true,
                'message'=>'You can not delete Default Category',
            ]);
        }
        $CatgoryList->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Category Delete',
        ]);
        
    }
    
    public function allCategory(Request $request)
    {
        $active=0;
        $expired=0;
        $complete=0;
        $delete=0;

        $token = $request->bearerToken();
        $user=User::where('remember_token',$token)->first();
        $CatgoryList=CatgoryList::where('user_id',$user->id)->get()->toArray();

      

        //return new Category(CatgoryList::get());;
        return response()->json([
            'success'=>true,
            'message'=>'Category found',
            'data'=>$CatgoryList
        ]);
    }
}
