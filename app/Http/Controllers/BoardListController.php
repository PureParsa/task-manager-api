<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardList\StoreBoardListRequest;
use App\Http\Requests\BoardList\UpdateBoardListRequest;
use App\Http\Resources\BoardListResource;
use App\Models\Board;
use App\Models\BoardList;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BoardListController extends Controller
{
    public function index(board  $board)
    {
        $this->authorize('view' , $board);
        $lists = $board->lists()->orderBy('created_at', 'desc')->get();
        return response()->json(BoardListResource::collection($lists), 200);
    }

    public function store(StoreBoardListRequest $request, board $board){
        $this->authorize('update' , $board);

        $validated = $request->validated();
        $list =$board->lists()->create($validated);
        return response()->json(new BoardListResource($list), 201);
    }
    public function show(Board $board, BoardList $list)
    {
        $this->authorize('view' , $board);

        return response()->json(new BoardListResource($list), 200);
    }

    public function update(UpdateBoardListRequest $request, board $board, BoardList $list)
    {
        $this->authorize('update' , $board);

        $validated = $request->validated();
        $list->update($validated);
        return response()->json(new BoardListResource($list), 200);
    }
    public function destroy(Board $board, BoardList $list)
    {
        $this->authorize('delete', $board);
        $list->delete();
        return response()->json(null, 204);
    }

}
