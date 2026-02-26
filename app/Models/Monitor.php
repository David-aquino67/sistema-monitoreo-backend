<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    protected $table = 'monitores_servidores';
    protected $primaryKey = 'REGISTRO_id';
    public $timestamps = false;
    protected $fillable = [
        'FK_id_unidad',
        'FK_id_monitor_kuma'
    ];
}
