<?php

namespace App\Repositories;

class encontrarConnectionData implements Interfaces\encontrarConnectionData
{

    public function encontrarConnectionData(int $unidadId): ?object
    {
        return DB::table('monitor_conexion')
            ->join('tblCons', function ($join) {
                $join->on(
                    'monitor_conexion.constant_id',
                    '=',
                    DB::raw('tblCons.ConstantID COLLATE SQL_Latin1_General_CP1_CI_AS')
                );
            })
            ->where('monitor_conexion.unidad_id', $unidadId)
            ->select('tblCons.Username', 'tblCons.Password', 'tblCons.Hostname', 'tblCons.Port')
            ->first();
    }
}
