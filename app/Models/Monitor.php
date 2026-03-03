<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monitor extends Model 
{
    protected $connection = 'kuma';
    protected $table = "monitor";
    protected $primaryKey = "id";
    public $timestamps = false; 
}