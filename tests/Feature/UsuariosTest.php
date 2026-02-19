<?php

use App\Models\Usuario;
uses(Tests\TestCase::class);

function crearUsuarioGenerico($id_sibop, $admin){
    $response = test()->actingAs($admin)->postJson('api/usuarios', [
        'FK_permiso_ability' => 'directivo',
        'id_sibop' => $id_sibop,
    ]);    
    return $response;
}

test('GET: api/usuarios | Responde correctamente para el administrador', function () {
    $admin = Usuario::find(1);
    $response = $this->actingAs($admin)->getJson('api/usuarios', []);    
    $response->assertStatus(200);
});

test('GET: api/usuarios/{id_sibop} | Responde correctamente para el administrador', function () {
    $admin = Usuario::find(1);
    $response = $this->actingAs($admin)->getJson('api/usuarios/1', []);    
    $response->assertStatus(200);
});

test('GET: api/usuarios/search | Responde correctamente para el administrador', function () {
    $admin = Usuario::find(1);
    $response = $this->actingAs($admin)->getJson('api/usuarios/search?matricula=31122', []);    
    $response->assertStatus(200);
    $data = $response->json();
    expect($data)->toBeArray();
    expect(count($data))->toBeGreaterThanOrEqual(5);
});

test('POST: api/usuarios | Responde correctamente al importar un usuario valido del SIBOP', function () {
    $admin = Usuario::find(1);
    $response = crearUsuarioGenerico(admin: $admin, id_sibop: env('SIBOP_TEST_RANDOM_USER_ID'));
    $response->assertStatus(201);
});

test('POST: api/usuarios | Responde correctamente al intentar importar un usuario duplicado', function () {
    $admin = Usuario::find(1);
    $response = crearUsuarioGenerico(admin: $admin, id_sibop: 1);
    $response->assertStatus(422);
});

test('PUT: api/usuarios | Responde correctamente al actualizar un usuario existente', function () {
    $admin = Usuario::find(1);
    $id = env('SIBOP_TEST_RANDOM_USER_ID');
    crearUsuarioGenerico(admin: $admin, id_sibop: $id);
    $response = $this->actingAs($admin)->putJson("api/usuarios/{$id}", [
        'FK_permiso_ability' => 'administrativo',
		'id_sibop_jefe' => 1,
    ]);    
    $response->assertStatus(204);
});

test('PUT: api/usuarios | Responde correctamente al intentar actualizar un usuario inexistente', function () {
    $admin = Usuario::find(1);
    $id = env('SIBOP_TEST_UNEXISTENT_USER_ID');
    $response = $this->actingAs($admin)->putJson("api/usuarios/$id", [
        'FK_permiso_ability' => 'administrativo',
		'id_sibop_jefe' => 1,
    ]);    
    $response->assertStatus(422);
});

test('DELETE: api/usuarios | Responde correctamente al eliminar un usuario existente', function () {
    $admin = Usuario::find(1);
    $id = env('SIBOP_TEST_RANDOM_USER_ID');
    $response = crearUsuarioGenerico(admin: $admin, id_sibop: $id);
    $response = $this->actingAs($admin)->deleteJson("api/usuarios/$id", []);    
    $response->assertStatus(204);
});

test('DELETE: api/usuarios | Responde correctamente al eliminar un usuario inexistente', function () {
    $admin = Usuario::find(1);
    $id = env('SIBOP_TEST_UNEXISTENT_USER_ID');
    $response = $this->actingAs($admin)->deleteJson("api/usuarios/$id", []);    
    $response->assertStatus(422);
});


afterEach(function () {
   Usuario::where('id_sibop', 5)->delete(); 
});