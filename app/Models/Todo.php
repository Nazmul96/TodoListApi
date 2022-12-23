<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $table = "todo";
    protected $fillable = ['category_id','subcat_id','title','description','start_time','recurring','who_it_for','second_signature','quick_log'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class,'subcat_id','id');
    }
}
