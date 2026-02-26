<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    protected $table = "monitor";
    protected $primaryKey = "id";
    protected $name = "name";
    protected $interval = "interval";
    protected $type = "type";

    protected $connection = 'kuma'; // <--- Indica la conexión de MariaDB
    public $timestamps = false;
}
