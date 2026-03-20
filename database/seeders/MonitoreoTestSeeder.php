<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonitoreoTestSeeder extends Seeder
{
    public function run()
    {
        // Limpiamos datos previos para evitar duplicados
        DB::table('monitor_conexion')->where('unidad_id', 999)->delete();
        DB::table('tblCons')->where('ConstantID', 'TEST-123-ABC')->delete();

        // 1. Insertamos solo los campos que sabemos que existen y son obligatorios
        // Si una columna sigue fallando, la comentaremos, pero estos son los vitales:
        DB::table('tblCons')->insert([
            'ConstantID' => 'TEST-123-ABC',
            'Name'       => 'Servidor de Prueba',
            'Hostname'   => '127.0.0.1',
            'Username'   => 'admin_test',
            'Password'   => '71/1OCtO9hulAX1YS721qQ==', // password123
            'Protocol'   => 'RDP',
            'Port'       => 3389,
            'LastChange' => date('Ymd H:i:s'), 
            'PositionID' => 0,
            'Icon'       => 'Default',
            'Panel'      => 'General',
            'Expanded'   => 0,
            'Type'       => 'Connection',
            'Connected'  => 0,
            'ConnectToConsole' => 0,
            'UseCredSsp'       => 0,
            'ICAEncryptionStrength'  => 'None',
            'RDPAuthenticationLevel' => 'None',
            'Colors'                 => 'HighColor',
            'Resolution'             => 'FitToWindow',
            'DisplayWallpaper'       => 0,
            'DisplayThemes'          => 0,
            'EnableFontSmoothing'    => 0,
            'EnableDesktopComposition' => 0,
            'CacheBitmaps'           => 0,
            'RedirectDiskDrives'     => 0,
            'RedirectPorts'          => 0,
            'RedirectPrinters'       => 0,
            'RedirectSmartCards'     => 0,
            'RedirectSound'          => 'None',
            'RedirectKeys'           => 0,
            'RDGatewayUsageMethod'   => 'None',
            'RDGatewayUseConnectionCredentials' => 'No',
            'VNCViewOnly'            => 0,
            // Agregamos las herencias básicas que son NOT NULL
            'InheritCacheBitmaps' => 0, 'InheritColors' => 0, 'InheritDescription' => 0,
            'InheritDisplayThemes' => 0, 'InheritDisplayWallpaper' => 0,
            'InheritEnableFontSmoothing' => 0, 'InheritEnableDesktopComposition' => 0,
            'InheritDomain' => 0, 'InheritIcon' => 0, 'InheritPanel' => 0,
            'InheritPassword' => 0, 'InheritPort' => 0, 'InheritProtocol' => 0,
            'InheritPuttySession' => 0, 'InheritRedirectDiskDrives' => 0,
            'InheritRedirectKeys' => 0, 'InheritRedirectPorts' => 0,
            'InheritRedirectPrinters' => 0, 'InheritRedirectSmartCards' => 0,
            'InheritRedirectSound' => 0, 'InheritResolution' => 0, 
            'InheritUseConsoleSession' => 0, 'InheritUseCredSsp' => 0, 
            'InheritRenderingEngine' => 0, 'InheritICAEncryptionStrength' => 0, 
            'InheritRDPAuthenticationLevel' => 0, 'InheritUsername' => 0,
        ]);

        // 2. Mapear a la Unidad SIBOP 999
        DB::table('monitor_conexion')->insert([
            'unidad_id'   => 999,
            'constant_id' => 'TEST-123-ABC',
            'created_at'  => date('Ymd H:i:s')
        ]);
    }
}