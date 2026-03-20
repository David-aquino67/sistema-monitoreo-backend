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
            ->join('tblCons', 'monitor_conexion.constant_id', '=', 'tblCons.ConstantID')
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