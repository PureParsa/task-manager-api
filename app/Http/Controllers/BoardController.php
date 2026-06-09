<?php

namespace App\Http\Controllers;

use App\Http\Requests\Board\StoreBoardRequest;
use App\Http\Requests\Board\UpdateBoardRequest;
use App\Http\Resources\BoardResource;
use App\Models\Board;
class BoardController extends Controller
{
    public function index(){

        $boards = auth()->user()->boards;
        return response()->json(BoardResource::collection($boards),200);
    }

    public function store(StoreBoardRequest $request){
        $validated = $request->validated();
        $board = Board::create([
            'title' => $validated['title'],
            'user_id' => auth()->id(),
        ]);
        return response()->json(new BoardResource($board),201);
    }

    public function update(UpdateBoardRequest $request, Board $board)
    {
        $this->authorize('update',$board);
        $validated = $request->validated();
        $board->update($validated);
        return response()->json(new BoardResource($board), 200);
    }
    public function show(board $board){
        $this->authorize('view',$board);
        return response()->json(new BoardResource($board), 200);
    }
    public function destroy(Board $board){
        $this->authorize('delete',$board);

        $board->delete();
        return response()->json(null, 204);
    }
}
