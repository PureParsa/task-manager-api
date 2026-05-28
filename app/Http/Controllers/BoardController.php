<?php

namespace App\Http\Controllers;

use App\Http\Requests\Board\StoreBoardRequest;
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
}
