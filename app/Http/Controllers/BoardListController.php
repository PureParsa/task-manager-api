<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardList\StoreBoardListRequest;
use App\Http\Requests\BoardList\UpdateBoardListRequest;
use App\Models\Board;
use App\Models\BoardList;
use Illuminate\Http\Request;

class BoardListController extends Controller
{
    public function index(board  $board)
    {
        if($board->user_id != auth()->user()->id){
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $lists = $board->boardLists()->orderBy('created_at', 'desc')->get();
        return response()->json($lists, 200);
    }

    public function store(StoreBoardListRequest $request, board $board){
        if($board->user_id != auth()->user()->id){
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $validated = $request->validated();
        $list =$board->boardLists()->create($validated);
        return response()->json($list, 201);
    }
    public function show(Board $board, BoardList $list)
    {
        if ($board->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json($list, 200);
    }

    public function update(UpdateBoardListRequest $request, board $board, BoardList $list)
    {
        if($board -> user_id !== auth()->id()){
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $validated = $request->validated();
        $list->update($validated);
        return response()->json($list->fresh(), 200);
    }
    public function destroy(Board $board, BoardList $list)
    {
        if($board -> user_id !== auth()->id()){
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $list->delete();
        return response()->json(null, 204);
    }

}
