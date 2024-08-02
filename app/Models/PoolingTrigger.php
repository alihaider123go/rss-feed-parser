<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoolingTrigger extends Model
{
    use HasFactory;

    protected $fillable = [
        'feed_url',
        'title',
        'interval',
        'user_id',
        'last_updated_job_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alertActions()
    {
        return $this->hasMany(AlertAction::class);
    }
}
