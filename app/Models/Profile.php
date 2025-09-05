<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'birthday',
        'telegram',
        'height',
        'weight',
    ];

    protected $hidden = [
        'user_id',
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
