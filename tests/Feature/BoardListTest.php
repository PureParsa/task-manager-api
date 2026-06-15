<?php
use App\Models\User;
use App\Models\Board;
use App\Models\BoardList;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Authenticated user can create a list under their board', function () {
    $user = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user , 'sanctum')->postJson("/api/boards/{$board->id}/lists",['title' => 'test list']);

    $response->assertStatus(201)->assertJson(['title' => 'test list' , 'board_id' => $board->id]);
});

test('User cannot create a list under another users board',function(){
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user1->id]);

    $response = $this->actingAs($user2 , 'sanctum')->postJson("/api/boards/{$board->id}/lists",['title' => 'test list']);

    $response->assertStatus(403);
});

test(' User can view lists of their own board', function () {

    $user = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user->id]);
    $lists = BoardList::factory()->count(3)->create(['board_id' => $board->id]);
    $response = $this->actingAs($user,'sanctum')->getJson("/api/boards/{$board->id}/lists");

    $response->assertStatus(200)->assertJsonCount(3);
});

test ('User cannot view lists of another users board' ,  function(){
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $board = Board::factory()->create(['user_id'=> $user1->id]);
    $lists = BoardList::factory()->count(3)->create(['board_id' => $board->id]);

    $response = $this->actingAs($user2 , 'sanctum')->getJson("/api/boards/{$board->id}/lists");

    $response->assertStatus(403);
});

test('User can update a list in their own board', function () {

    $user = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user->id]);
    $lists = BoardList::factory()->create(['board_id' => $board->id]);

    $response = $this->actingAs($user, 'sanctum')->patchJson("/api/boards/{$board->id}/lists/{$lists->id}", [
        'title' => 'Updated Title',
    ]);

    $response->assertStatus(200)->assertJson(['title' => 'Updated Title']);
});

test('User can delete a list from their own board', function () {

    $user = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user->id]);
    $lists = BoardList::factory()->create(['board_id' => $board->id]);

    $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/boards/{$board->id}/lists/{$lists->id}");

    $response->assertStatus(204);
});
test('Resource not found returns 404', function () {

    $user = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user->id , 'id' => 3]);
    $lists = BoardList::factory()->create(['board_id' => $board->id,'id' => 3]);

    $response = $this->actingAs($user, 'sanctum')->getJson("/api/boards/3/lists/2");

    $response->assertStatus(404);
});
