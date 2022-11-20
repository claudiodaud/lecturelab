<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameters extends Model
{
    use HasFactory;

    protected /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
        'control',
        'type_var',
        'value'
    ];
}
