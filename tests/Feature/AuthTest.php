<?php
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
test('user can register with valid data', function () {

    $response = $this->postJson('/api/register',
        [
            'name' =>'parsa',
            'email' => 'user@gmail.com' ,
            'password' => 'password123' ,
            'password_confirmation' => 'password123',
        ] );

    $response->assertStatus(201)->assertJsonStructure([
        'user' => ['id', 'name', 'email'],
        'token',
    ]);
});

test('user cannot register with missing data', function () {

    $response = $this->postJson('/api/register',
        [
            'name' =>'test',
        ] );

    $response->assertStatus(422);
    $this->assertDatabaseMissing('users', ['name' => 'test']);
});
test('user can login with correct credentials ', function () {
    $user = User::factory()->create([ 'password' => Hash::make('password123')]);
    $response = $this->postJson('/api/login',
        [
            'email' => $user->email ,
            'password' => 'password123' ,
        ] );

    $response->assertStatus(200);
});
test('user cannot login with wrong credentials', function () {
    $user = User::factory()->create([ 'password' => Hash::make('password123')]);
    $response = $this->postJson('/api/login',
        [
            'email' => $user->email ,
            'password' => 'password12' ,
        ] );

    $response->assertStatus(401);
});
test('user can logout', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user,'sanctum')->postJson('/api/logout');

    $response->assertStatus(200);
    $this->assertDatabaseCount('personal_access_tokens', 0);

});
