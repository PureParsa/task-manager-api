<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    protected $fillable = ['title' ,'user_id'];

public function user(): belongsTo
{
    return $this->belongsTo(User::class);
}
public function lists(): HasMany
{
    return $this->hasMany(BoardList::class);
}
}
