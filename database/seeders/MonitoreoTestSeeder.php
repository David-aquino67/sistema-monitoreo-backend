<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonitoreoTestSeeder extends Seeder
{
    public function run()
    {
       
        DB::table('tblCons')->insert([
            'ConstantID' => 'TEST-123-ABC',
            'Name' => 'Servidor de Prueba',
            'Hostname' => '127.0.0.1',
            'Username' => 'admin_test',
            'Password' => '71/1OCtO9hulAX1YS721qQ==', 
            'Protocol' => 'RDP',
            'Port' => 3389,
            'LastChange' => now(),
            'PositionID' => 0,
            'Icon' => 'Default',
            'Panel' => 'General',
            'Expanded' => 0,
            'Type' => 'Connection',
            'ICAEncryptionStrength' => 'None',
            'RDPAuthenticationLevel' => 'None',
            'RDPMinutesToIdleTimeout' => 0,
            'RDPAlertIdleTimeout' => 0,
            'Colors' => 'HighColor',
            'Resolution' => 'FitToWindow',
            'RedirectSound' => 'None',
            'SoundQuality' => 'Dynamic',
            'RDGatewayUsageMethod' => 'None',
            'RDGatewayUseConnectionCredentials' => 'No',
            'Connected' => 0
        ]);

        DB::table('monitor_conexion')->insert([
            'unidad_id' => 999,
            'constant_id' => 'TEST-123-ABC',
            'created_at' => now()
        ]);
    }
}