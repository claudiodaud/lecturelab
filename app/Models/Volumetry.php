<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volumetry extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'co',
        'cod_carta',
        'method',
        'element',
        'number',
        'name',
        
        'weight',
        'chq',
        'spent',
        'grade',
        'title',
        
        'updated_by',
        'updated_date', 
        'written_by',
       
    ];
}
