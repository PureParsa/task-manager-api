<?php

namespace App\Http\Controllers;

use App\Http\Requests\Board\UpdateBoardRequest;
use App\Http\Requests\Card\StoreCardRequest;
use App\Http\Requests\Card\UpdateCardRequest;
use App\Models\Board;
use App\Models\BoardList;
use App\Models\Card;


class CardController extends Controller
{
    public function index(Board $board, BoardList $list)
    {
        if($list -> board->user_id !== auth()->id())
        {
            return response()->json(['message' =>'Forbidden'] , 403);
        }
        $cards = $list->cards;
        return response()->json($cards, 200);
    }

    public function store(StoreCardRequest $request,Board $board , BoardList $list)
    {
        if($list->board->user_id !== auth()->id())
        {
            return response()->json(['message' =>'Forbidden'] , 403);
        }
        $validated = $request->validated();

        $cards =$list->cards()->create($validated);
        return response()->json($cards, 201);
    }
    public function show(Board $board , BoardList $list , Card $card)
    {
        if($list->board->user_id !== auth()->id())
        {
            return response()->json(['message' =>'Forbidden'] , 403);
        }
        return response()->json($card ,200 );
    }
    public function update(UpdateCardRequest $request , Board $board , BoardList $list ,Card $card)
    {
        if($list->board->user_id !== auth()->id())
        {
            return response()->json(['message' =>'Forbidden'] , 403);
        }
        $validated = $request->validated();
        $card->update($validated);
        return response()->json($card , 200);
    }
    public function destroy(UpdateCardRequest $request , Board $board , BoardList $list ,Card $card)
    {
        if($list->board->user_id !== auth()->id())
        {
            return response()->json(['message' =>'Forbidden'] , 403);
        }
        $card->delete();
        response()->json(null ,204 );
    }
}
