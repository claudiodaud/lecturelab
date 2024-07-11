<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use HasFactory;

    protected $fillable = [
        'volumetry_id',
        'sample_name',
        'method',
        'element',
        'co',
        'cart',
        'weight1',
        'weight2',
        'weight3',
        'weight4',
        'weight5',
        'weight6',
        'vol1',
        'vol2',
        'vol3',
        'vol4',
        'vol5',
        'vol6',
        'grade1',
        'grade2',
        'grade3',
        'grade4',
        'grade5',
        'grade6',
        'title1',
        'title2',
        'title3',
        'title4',
        'title5',
        'title6',
        'title',
        'titling',
        'titleCalculated',
        'weightX',
        'volX',
        'gradeX',
        'titleX',
        'update_user_id',

    ];

    /**
     * Title belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        // belongsTo(RelatedModel, foreignKey = user_id, keyOnRelatedModel = id)
        return $this->belongsTo(User::class,'update_user_id');
    }

    /**
     * Title belongs to Sample.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sample()
    {
        // belongsTo(RelatedModel, foreignKey = sample_id, keyOnRelatedModel = id)
        return $this->belongsTo(Sample::class);
    }
}
