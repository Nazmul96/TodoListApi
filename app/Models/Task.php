<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = "tasks";
    protected $fillable = ['user_id','category_id','task_title','due_date','time_set','repeat','status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
     public function CatgoryList()
    {
        return $this->belongsTo(CatgoryList::class,'category_id','id');
    }
}
