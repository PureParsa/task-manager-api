<?php
use App\Models\User;
use App\Models\Board;
use App\Models\BoardList;
use App\Models\Card;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated user can create a card' , function(){

    $user = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user->id ]);
    $list = BoardList::factory()->create(['board_id' => $board->id] );

    $response = $this->actingAs($user , 'sanctum') ->postJson("/api/boards/{$board->id}/lists/{$list->id}/cards" , ['title' => 'new card'] );

    $response->assertStatus(201)->assertJson(['title' => 'new card']);
});

test('unauthenticated user cannot create a card',function(){
    $user = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user->id ]);
    $list = BoardList::factory()->create(['board_id' => $board->id] );

    $response = $this->postJson("/api/boards/{$board->id}/lists/{$list->id}/cards" , ['title' => 'new card'] );

    $response->assertStatus(401);
});

test ('Validation fails with missing data', function(){
    $user = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user->id]);
    $list = BoardList::factory()->create(['board_id' => $board->id ] );

    $response = $this->actingAs($user , 'sanctum') ->postJson("/api/boards/{$board->id}/lists/{$list->id}/cards");

    $response->assertStatus(422);
});


test('user cannot view cards in another users list',function(){
    $user = User::factory()->create();
    $user2 = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user->id]);
    $list = BoardList::factory()->create(['board_id' => $board->id ] );
    $cards = Card::factory()->count(5)->create(['board_list_id' => $list->id]);

    $response = $this->actingAs($user2 , 'sanctum') ->getJson("/api/boards/{$board->id}/lists/{$list->id}/cards");

    $response->assertStatus(403)->assertJsonCount(5);
});

test('user can view all cards in their list', function () {

    $user = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user->id]);
    $list = BoardList::factory()->create(['board_id' => $board->id] );
    $cards = Card::factory()->count(5)->create(['board_list_id' => $list->id]);

    $response = $this->actingAs($user , 'sanctum') ->getJson("/api/boards/{$board->id}/lists/{$list->id}/cards");

    $response->assertStatus(200)->assertJsonCount(5);
});


test('user can update their own card', function () {

    $user = User::factory()->create();
    $board = Board::factory()->create(['user_id'=> $user->id]);
    $list = BoardList::factory()->create(['board_id' => $board->id , 'id' => 1]);
    $card = Card::factory()->create(['board_list_id' => $list->id]);

    $response = $this->actingAs($user, 'sanctum')->patchJson("/api/boards/{$board->id}/lists/{$list->id}/cards/{$card->id}", [
        'title' => 'Updated Title',
    ]);

    $response->assertStatus(200)->assertJson(['title' => 'Updated Title']);
});

test('user can delete their own card', function () {

    $user = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user->id]);
    $list = BoardList::factory()->create(['board_id' => $board->id]);
    $card = Card::factory()->create(['board_list_id' => $list->id ]);

    $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/boards/{$board->id}/lists/{$list->id}/cards/{$card->id}");

    $response->assertStatus(204);
});
test('Resource not found returns 404', function () {

    $user = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user->id]);
    $list = BoardList::factory()->create(['board_id' => $board->id]);
    $card = Card::factory()->create(['board_list_id' => $list->id , 'id' => 2] );

    $response = $this->actingAs($user, 'sanctum')->getJson("/api/boards/{$board->id}/lists/{$list->id}/cards/1");
    $response->assertStatus(404);
});
