<?php

namespace App\Models;

use App\Models\User;
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

    /**
     * Volumetry belongs to .
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function writtenUser()
    {
        // belongsTo(RelatedModel, foreignKey = _id, keyOnRelatedModel = id)
        return $this->belongsTo(User::class,'written_by','id');
    }

    /**
     * Volumetry belongs to .
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedUser()
    {
        // belongsTo(RelatedModel, foreignKey = _id, keyOnRelatedModel = id)
        return $this->belongsTo(User::class,'updated_by','id');
    }
}
