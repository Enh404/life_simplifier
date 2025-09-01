<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'name',
        'activate_at',
        'user_id',
        'type_id',
    ];

    protected $hidden = [
        'user_id',
        'type_id',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'user',
        'type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(EventType::class, 'type_id');
    }

    public function getUserAttribute()
    {
        return $this->user()->get()->first();
    }

    public function getTypeAttribute()
    {
        return $this->type()->get()->first();
    }
}
