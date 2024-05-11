<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostLike extends Model
{
    use HasFactory;

    protected $table = 'post_likes';

    protected $fillable = ['user_id', 'post_id'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(UserPost::class, 'post_id', 'id');
    }
}
