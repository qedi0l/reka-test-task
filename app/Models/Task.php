<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserList;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'tags',
        'data',
    ];

    public function belongsTolist(){
        return $this->belongsTo('App\Models\UserList');
    }
}

