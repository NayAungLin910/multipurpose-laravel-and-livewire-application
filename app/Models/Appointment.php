<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'date',
        'status',
        'time',
        'note'
    ];

    protected $guarded = [];

    // was commented out because of update appointment bug
    protected $casts = [
        'date' => 'datetime',
        // 'time' => 'datetime',
    ];

    protected $appends = [
        'statusBadge',
        'humanReadableDate',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'scheduled' => 'primary',
            'closed' => 'success',
            'open' => 'warning',
        ];
        return $badges[$this->status];
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->toFormattedDate();
    }

    public function getHumanReadableDateAttribute()
    {
        return Carbon::parse($this->time)->format('h:i A');
    }
}
