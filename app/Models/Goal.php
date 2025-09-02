<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Goal extends Model
{
    protected $fillable = [
        'name',
        'completed',
        'user_id',
    ];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'user',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getUserAttribute()
    {
        return $this->user()->get()->first();
    }
}
