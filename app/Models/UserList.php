<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;


class UserList extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'tags',
        'data',
        'owner',
        'hasAccess',
    ];
    public function tasks(){
        return $this->hasMany('App\Models\Task')->orderBy('id','asc');
    }

    
}
