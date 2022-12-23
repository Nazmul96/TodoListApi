<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = "clients";
    protected $fillable = ['name', 'email', 'gender','date_of_birth','status','assign_to_carer','assign_to_carer'];
}
