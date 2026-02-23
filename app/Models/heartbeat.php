<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Heartbeat extends Model
{
    private $table = "heartbeat";
    private $primaryKey = "id";
    private $monitor_id = "monitor_id";
    private $status = "status";
    private $msg = "msg";
    private $time = "time";
    private $ping = "ping";
}