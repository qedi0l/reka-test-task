<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Search\Searchable;

class File extends Model
{
    use HasFactory;
    #use Searchable;
    protected $fillable = [
        'path'
    ];
    protected $filepath = ['path'];
}
