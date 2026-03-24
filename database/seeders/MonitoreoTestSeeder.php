<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonitoreoTestSeeder extends Seeder
{
    public function run()
    {
        // 1. Limpiamos datos previos para evitar errores de duplicidad
        DB::table('monitor_conexion')->where('unidad_id', 999)->delete();
        DB::table('tblCons')->where('ConstantID', 'TEST-123-ABC')->delete();

        // 2. Insertamos usando una consulta SQL cruda simplificada
        // Esto evita que Laravel intente validar columnas que no estamos enviando
        DB::statement("
            INSERT INTO tblCons (
                ConstantID, Name, Hostname, Username, [Password], Protocol, Port, 
                LastChange, PositionID, Icon, Panel, Expanded, [Type], Connected,
                ConnectToConsole, UseCredSsp, ICAEncryptionStrength, RDPAuthenticationLevel,
                RDPMinutesToIdleTimeout, RDPAlertIdleTimeout, Colors, Resolution,
                DisplayWallpaper, DisplayThemes, EnableFontSmoothing, EnableDesktopComposition,
                CacheBitmaps, RedirectDiskDrives, RedirectPorts, RedirectPrinters,
                RedirectSmartCards, RedirectSound, SoundQuality, RedirectKeys,
                RDGatewayUsageMethod, RDGatewayUseConnectionCredentials, VNCViewOnly,
                InheritCacheBitmaps, InheritColors, InheritDescription, InheritDisplayThemes,
                InheritDisplayWallpaper, InheritEnableFontSmoothing, InheritEnableDesktopComposition,
                InheritDomain, InheritIcon, InheritPanel, InheritPassword, InheritPort,
                InheritProtocol, InheritPuttySession, InheritRedirectDiskDrives, InheritRedirectKeys,
                InheritRedirectPorts, InheritRedirectPrinters, InheritRedirectSmartCards,
                InheritRedirectSound, InheritSoundQuality, InheritResolution, 
                InheritUseConsoleSession, InheritUseCredSsp, InheritRenderingEngine,
                InheritICAEncryptionStrength, InheritRDPAuthenticationLevel, 
                InheritRDPMinutesToIdleTimeout, InheritRDPAlertIdleTimeout, InheritUsername,
                InheritPreExtApp, InheritPostExtApp, InheritMacAddress, InheritUserField,
                InheritExtApp, InheritVNCCompression, InheritVNCEncoding, InheritVNCAuthMode,
                InheritVNCProxyType, InheritVNCProxyIP, InheritVNCProxyPort, InheritVNCProxyUsername,
                InheritVNCProxyPassword, InheritVNCColors, InheritVNCSmartSizeMode, InheritVNCViewOnly,
                InheritRDGatewayUsageMethod, InheritRDGatewayHostname, InheritRDGatewayUseConnectionCredentials,
                InheritRDGatewayUsername, InheritRDGatewayPassword, InheritRDGatewayDomain
            ) VALUES (
                'TEST-123-ABC', 'Servidor de Prueba', '127.0.0.1', 'admin_test', 
                '71/1OCtO9hulAX1YS721qQ==', 'RDP', 3389, 
                GETDATE(), 0, 'Default', 'General', 0, 'Connection', 0,
                0, 0, 'None', 'None', 0, 0, 'HighColor', 'FitToWindow',
                0, 0, 0, 0, 0, 0, 0, 0, 0, 'None', 'Dynamic', 0,
                'None', 'No', 0,
                0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0
            )
        ");

        // 3. Mapear a la Unidad SIBOP 999
        DB::table('monitor_conexion')->insert([
            'unidad_id'   => 999,
            'constant_id' => 'TEST-123-ABC',
            'created_at'  => now()
        ]);
    }
}