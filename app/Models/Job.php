<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    protected $table = 'job';
    public $timestamps = false;

    protected $fillable = [
        'start_address',
        'destination_address',
        'recipient_name',
        'recipient_phone',
        'status',
        'driver_email',
    ];

     protected $attributes = [
        'status' => 'Assigned',
    ];

    public const STATUS_ASSIGNED   = 'Assigned';
    public const STATUS_INPROGRESS = 'InProgress';
    public const STATUS_SUCCESSFUL = 'Successful';
    public const STATUS_FAILED     = 'Failed';

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_email', 'email');
    }
}
