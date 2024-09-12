<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Issue extends Model
{
    use HasFactory;

    protected $appends = ['title', 'last_seen', 'since', 'type'];

    public function getTitleAttribute()
    {
        $lines = explode("\n", $this->message);

        return trim($lines[0]);
    }

    public function getLastSeenAttribute()
    {
        $lastEvent = $this->events()->orderBy('occurred_at', 'desc')->first();
        $date = Carbon::parse($lastEvent->occurred_at);
        $relative = Carbon::now()->sub($date)->shortRelativeDiffForHumans();

        return [
            'date' => $date,
            'relative' => $relative,
        ];
    }

    public function getSinceAttribute()
    {
        $firstEvent = $this->events()->orderBy('occurred_at', 'asc')->first();
        $date = Carbon::parse($firstEvent->occurred_at);
        $relative = Carbon::now()->sub($date)->shortRelativeDiffForHumans();

        return [
            'date' => $date,
            'relative' => $relative,
        ];
    }

    public function getTypeAttribute()
    {
        return strpos($this->message, 'Exception') !== false ? 'EX' : 'ER';
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
