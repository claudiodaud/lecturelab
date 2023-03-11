<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iron extends Model
{
    use HasFactory;

    protected $fillable = [
        'co',
        'number',                          
        'name',                      
        'chq',
        'iron_grade',
        'geo615', 
        'geo618', 
        'geo644', 
        'comparative',
        'cod_carta',       
        'element',   
        'updated_by',
        'updated_date',
        'written_by',
    ];
}
