<?php

use App\Models\User;
use App\Models\Board;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

#AAA

test('Authenticated user can create board',function(){

    $user = User::factory()->create();
    $response = $this->actingAs($user,'sanctum')->postJson('/api/boards', ['title' => 'new board']);

    $response->assertStatus(201);

}
);

test('Unauthenticated user cannot create board',function(){
        $response = $this->postJson('/api/boards', ['title' => 'test board']);
        $response->assertStatus(401);
});

test('user can view their own board', function () {

    $user = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user->id]);
    $response = $this->actingAs($user,'sanctum')->getJson("/api/boards/{$board->id}");
    $response->assertStatus(200)
            ->assertJson(['id' => $board->id, 'title' => $board->title]);
});


test('user can view their all boards', function(){
   $user = User::factory()->create();
   $boards = Board::factory()->count(10)->create(['user_id'=> $user->id]);

   $response =$this->actingAs($user,'sanctum') ->getJson('/api/boards');

   $response->assertStatus(200)->assertJsonCount(10);
});

test ('Validation fails with missing data', function(){
    $user = User::factory()->create();

    $response =$this->actingAs($user,'sanctum') ->postJson('/api/boards');

    $response->assertStatus(422);
});


test('User can update their own resource', function () {

    $user = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user, 'sanctum')->patchJson("/api/boards/{$board->id}", [
        'title' => 'Updated Title',
    ]);

    $response->assertStatus(200);
});

test('User can destroy their own resource', function () {

    $user = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user->id]);
    $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/boards/{$board->id}");
    $response->assertStatus(204);
});

test('Resource not found returns 404', function () {

    $user = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user->id ,'id' => 4]);
    $response = $this->actingAs($user, 'sanctum')->getJson("/api/boards/2");
    $response->assertStatus(404);
});
