<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Url extends Model
{
    protected $fillable = [
        'longUrl',
        'shortUrl'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
