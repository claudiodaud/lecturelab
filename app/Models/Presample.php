<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presample extends Model
{
    use HasFactory;

    
    protected $fillable = [
        
        'co',
        'cod_carta',
        'method',
        'element',
        'number',
        'name',
        'absorbance',
        'weight',
        'aliquot',
        'colorimetric_factor',
        'dilution_factor',
        'phosphorous',
        'updated_by',
        'updated_date', 
        'written_by',
    ];
}
