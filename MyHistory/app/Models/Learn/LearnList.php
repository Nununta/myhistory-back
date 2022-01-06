<?php

namespace App\Models\Learn;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use App\Models\Learn\LearnCard;
use App\Models\User;

class LearnList extends Model
{
    use SoftDeletes;

    //fillやfirstOrCreateをコントローラで使う際は必須
    protected $fillable = [
        'name'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cards():HasMany
    {
       return $this->hasMany(LearnCard::class,'list_id', 'id');
    }
}
