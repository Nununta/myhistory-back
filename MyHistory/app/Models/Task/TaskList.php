<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Task\TaskCard;
use App\Models\User;

class TaskList extends Model
{
    use SoftDeletes;

    //fillやfirstOrCreateをコントローラで使う際は必須
    protected $fillable = [
        'name',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cards():HasMany
    {
       return $this->hasMany(TaskCard::class,'list_id', 'id');
    }
}
