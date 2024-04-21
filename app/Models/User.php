<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $username
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

    public function profileRedirect(): RedirectResponse
    {
        if($this->username) {
            return redirect()->route('profile.view.username', ['username' => $this->username]);
        } else {
            return redirect()->route('profile.view.id', ['id' => $this->id]);
        }
    }
}
