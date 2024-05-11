<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
    protected $fillable = ['user_id', 'data', 'files'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class, 'post_id', 'id');
    }

    public function like(User $user): void
    {
        if ($this->likes()->where('user_id', $user->id)->exists()) {
            $this->likes()->where('user_id', $user->id)->delete();
        } else {
            $this->likes()->create(['user_id' => $user->id]);
        }
    }

    public function attachFiles($files): void
    {
        $filesUrl = [];
        foreach ($files as $file) {
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('public/posts/'.$this->id, $filename);
            chmod(storage_path('app/public/posts/'.$this->id), 0775);
            $filesUrl[] = Storage::url($path);
        }
        $this->files = $filesUrl;
        $this->save();
    }
}
