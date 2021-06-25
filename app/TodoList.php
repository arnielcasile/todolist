<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodoList extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name','status','completion_datetime','deadline_datetime'];
    protected $guarded  = ['id'];
}
