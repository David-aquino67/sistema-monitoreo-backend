<?php

use App\Services\Sibop;
uses(Tests\TestCase::class);

function login(){
    $sibopToken = Sibop::login(env('SIBOP_TEST_USER_ID'), env('SIBOP_TEST_USER_PWD'));
    $response = test()->withHeaders([
        'Authorization' => 'Bearer ' . $sibopToken,
    ])->postJson('api/auth/login', []);
    return $response;  
}

test('POST: api/auth/login | Responde correctamente al pasar un token valido del SIBOP', function () {
    $response = login();    
    $response->assertStatus(200);
});

test('GET: api/auth/logout | Responde correctamente al pasar un token valido del MOCACI', function () {
    $response = login();  
    $token = $response->json('token');  
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->getJson('api/auth/logout', []);
    $response->assertStatus(204);
});

test('GET: api/validate/token | Responde correctamente al pasar un token valido', function () {
    $response = login();  
    $token = $response->json('token');  
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->getJson('api/auth/validate/token', []);
    $response->assertStatus(200);
});

test('GET: api/validate/token | Responde correctamente al pasar un token no valido', function () {
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . 'abc',
    ])->getJson('api/auth/validate/token', []);
    $response->assertStatus(401);
});

test('GET: api/auth/validate/user/{id_usuario} | Responde correctamente al buscar un usuario aleatorio', function () {
    $randomInt = rand(1, 100);
    $response = $this->getJson("api/auth/validate/user/{$randomInt}", []);
    $response->assertStatus(200);
});