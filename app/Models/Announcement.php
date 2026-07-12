<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['message', 'background', 'ends_at'];

    protected $casts = [
        'ends_at' => 'datetime',
    ];

    /**
     * The site shows a single announcement at a time, so we treat the first
     * row as a singleton. Returns an (unsaved) blank instance when none exists.
     */
    public static function current(): self
    {
        return static::firstOrNew([]);
    }

    /**
     * Whether the announcement has a message and has not expired yet.
     */
    public function isActive(): bool
    {
        return !empty($this->message)
            && (is_null($this->ends_at) || now()->lessThan($this->ends_at));
    }
}
