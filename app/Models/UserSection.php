<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $name
 */
class UserSection extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_sections';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'name'];

    /**
     * Get the user that owns the section.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updateName(string $name): void
    {
        if ($name !== $this->name) {
            $this->name = $name;
            $this->save();
        }
    }

}