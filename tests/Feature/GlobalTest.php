<?php

use App\Models\Usuario;
use App\Models\Version;

uses(Tests\TestCase::class);

test('DELETE: api/global/cache | Responde correctamente al eliminar la cache', function () {
    $admin = Usuario::find(1);
    $response = $this->actingAs($admin)->deleteJson('api/global/cache', []);    
    $response->assertStatus(204);
});

test('GET: api/global/versiones | Obtiene todas las versiones', function () {
    $admin = Usuario::find(1);
    $response = $this->actingAs($admin)->getJson('api/global/versiones', []);    
    $response->assertStatus(200);
    $data = $response->json();
    expect($data)->toBeArray();
    expect(count($data))->toBeGreaterThanOrEqual(1);
	$found = false;
	foreach ($data as $version) {
		if (isset($version['numero_version']) && $version['numero_version'] === 'v1.0.0') {
			$found = true;
			break;
		}
	}
	expect($found)->toBeTrue();
	expect(count($data) == Version::count())->toBeTrue();
});

test('GET: api/global/versiones/ultima | Obtiene correctamente la ultima version', function () {
    $admin = Usuario::find(1);
    $response = $this->actingAs($admin)->getJson('api/global/versiones/ultima', []);    
    $response->assertStatus(200);
    $data = $response->json();
	$ultimaVersion = Version::orderBy('fecha_liberacion', 'desc')->first();
	expect($data['numero_version'])->toBe($ultimaVersion->numero_version);
});

test('GET: api/global/versiones/{version} | Obtiene correctamente la primer version', function () {
    $admin = Usuario::find(1);
    $response = $this->actingAs($admin)->getJson('api/global/versiones/v1.0.0', []);    
    $response->assertStatus(200);
});

test('GET: api/global/versiones/{version} | Responde correctamente al buscar versiones inexistentes', function () {
    $admin = Usuario::find(1);
    $response = $this->actingAs($admin)->getJson('api/global/versiones/v0.0.0', []);    
    $response->assertStatus(404);
});