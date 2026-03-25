<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;

class ConnectionService
{
    protected $encryption;
    public function __construct(EncryptionService $encryption)
    {
        $this->encryption = $encryption;
    }
   public function getCredentialsByUnidad($unidadId)
    {
    $conexion = DB::table('monitor_conexion')
        ->join('tblCons', function($join) {
            $join->on('monitor_conexion.constant_id', '=', DB::raw('tblCons.ConstantID COLLATE SQL_Latin1_General_CP1_CI_AS'));
        })
        ->where('monitor_conexion.unidad_id', $unidadId)
        ->select('tblCons.Username', 'tblCons.Password', 'tblCons.Hostname', 'tblCons.Port')
        ->first();

    if (!$conexion) return null;

    return [
        'host' => $conexion->Hostname,
        'user' => $conexion->Username,
        'port' => $conexion->Port,
        'pass' => $this->encryption->decryptMRemote($conexion->Password)
    ];
}
}