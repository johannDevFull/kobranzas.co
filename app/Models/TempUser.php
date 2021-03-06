<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempUser extends Model
{
    use HasFactory;
    protected $fillable=[
        'idTemp',
        'name',
        'status',
        'name_user'
    ];
}
