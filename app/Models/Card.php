<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    protected $fillable = ['title' , 'description' , 'position' , 'due_date'];

    public function list(): belongsTo
    {
        return $this->belongsTo(BoardList::class , 'board_list_id');
    }
}
