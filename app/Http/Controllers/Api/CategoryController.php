<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;

class CategoryController extends Controller
{
    public function index()
    {
        $category=Category::latest()->get();
        if(is_null($category))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Category not found',
            ]);
        }
        return response()->json([
            'success'=>true,
            'message'=>'Clients found',
            'data'=>$category,
        ]);
    }

    public function subCategory($id)
    {
        $subcategory=SubCategory::where('category_id',$id)->get()->toArray();
         // return response()->json([
         //        'error'=>true,
         //        'message'=>$id,
         //    ]);
        if(empty($subcategory))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Subcategory not found',
            ]);
        }

        return response()->json([
            'success'=>true,
            'message'=>'Subcategory found',
            'data'=>$subcategory,
        ]);
    }

    public function allSubCategory()
    {
       $allsubcategory=SubCategory::get()->toArray(); 

        if(empty($allsubcategory))
        {
            return response()->json([
                'error'=>true,
                'message'=>'Subcategory not found',
            ]);
        }

        return response()->json([
            'success'=>true,
            'message'=>'Subcategory found',
            'data'=>$allsubcategory,
        ]);
    }
}
