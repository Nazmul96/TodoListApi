<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatgoryList extends Model
{
    use HasFactory;
    protected $table = "category_list";
    protected $fillable = ['user_id','category_name','is_default'];
    protected $hidden = ['created_at','updated_at'];
    public function Task()
    {
        return $this->hasMany(Task::class,'category_id','id');
    }
}
