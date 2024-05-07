<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @property array $files
 * @property int $id
 */
class UserPost extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'section_id', 'title', 'content', 'files'];

    /**
     * Get the user that owns the section.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(UserSection::class);
    }

    public function attachFiles($files): void
    {
        $filesUrl = [];
        foreach ($files as $file) {
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('public/posts/'.$this->id, $filename);
            $filesUrl[] = Storage::url($path);
        }
        $this->files = $filesUrl;
        $this->save();
    }

    public function likeCount()
    {
        return PostLike::where('post_id', $this->id)->count();
    }

    public function isLiked(User $user)
    {
        return PostLike::where('user_id', $user->id)
            ->where('post_id', $this->id)
            ->exists();
    }
}
