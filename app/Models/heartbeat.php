<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Heartbeat extends Model
{
    
    protected $connection = 'kuma'; 
    protected $table = "heartbeat";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function monitor()
    {
        return $this->belongsTo(Monitor::class, 'monitor_id', 'id');
    }
}