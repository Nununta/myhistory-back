<?php

namespace App\Models\Learn;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Learn\LearnList;
use App\Models\User;

class LearnCard extends Model
{
    use SoftDeletes;
    //fillやfirstOrCreateをコントローラで使う際は必須
    protected $fillable = [
        'name','content','status','list_id','user_id'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function list():BelongsTo
    {
        return $this->belongsTo(LearnList::class);
    }
}
