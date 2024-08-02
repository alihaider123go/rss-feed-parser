<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipient_address',
        'subject',
        'body_items',
        'alert_type',
        'status',
        'pooling_trigger_id'
    ];

    public function poolingTrigger()
    {
        return $this->belongsTo(PoolingTrigger::class);
    }

}
