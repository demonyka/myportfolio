<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $username
 * @property string $email
 * @property mixed $external_data
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'username',
        'password',
        'external_data'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function profileRedirect(): RedirectResponse
    {
        if ($this->username) {
            return redirect()->route('profile.view.username', ['username' => $this->username]);
        } else {
            return redirect()->route('profile.view.id', ['id' => $this->id]);
        }
    }

    public function setAvatar($avatar): void
    {
        $filename = md5(time() . $this->id) . '.' . $avatar->getClientOriginalExtension();
        $path = $avatar->storeAs('public/avatars/' . $this->id, $filename);
        chmod(storage_path('app/public/avatars/' . $this->id), 0775);
        chmod(storage_path('app/' . $path), 0775);
        $avatarUrl = Storage::url($path);
        $this->setExternalData('avatar_path', $avatarUrl);
    }

    public function setExternalData(string $slug, $value): void
    {
        $externalData = json_decode($this->external_data, true);
        if (!$externalData) {
            $externalData = [];
        }
        $externalData[$slug] = $value;
        $this->external_data = json_encode($externalData);
        $this->save();
    }

    public function posts(): HasMany
    {
        return $this->hasMany(UserPost::class, 'user_id', 'id');
    }
}
