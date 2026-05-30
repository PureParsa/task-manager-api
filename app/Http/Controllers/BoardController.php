<?php

namespace App\Http\Controllers;

use App\Http\Requests\Board\StoreBoardRequest;
use App\Http\Requests\Board\UpdateBoardRequest;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoardController extends Controller
{
    public function index(){

        $boards = auth()->user()->boards;
        return JsonResource::collection($boards);
    }

    public function store(StoreBoardRequest $request){
        $validated = $request->validated();
        $board = Board::create([
            'title' => $validated['title'],
            'user_id' => auth()->id(),
        ]);
        return response()->json($board, 201);
    }

    public function update(UpdateBoardRequest $request, Board $board)
    {
        if ($board->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $validated = $request->validated();
        $board->update($validated);
        return response()->json($board, 200);
    }
    public function show(board $board){
        if ($board->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        return response()->json($board, 200);
    }
    public function destroy(Board $board){
        if ($board->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $board->delete();
        return response()->json(null, 204);
    }
}
