<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'adresse',
        "image",
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->matricule = self::generateMatricule();
        });
    }
    
    private static function generateMatricule()
    {
        $prefix = 'AG';
        $randomNumber = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4)); // 4 caractères aléatoires
        return $prefix . $randomNumber;
    }
    public function depenses()
    {
        return $this->hasMany(Depense::class);
    }
    public function entre()
    {
        return $this->hasMany(Entre::class);
    }
    public function imageUrl()
{
    // Vérifie si l'image commence déjà par http ou https
    if (str_starts_with($this->image, 'http')) {
        return $this->image;
    }
    
    // Sinon, retourne l'URL avec Storage
    return Storage::disk('public')->url($this->image);
}

public function profilUrl()
{
    // Vérifie si l'image commence déjà par http ou https
    if (str_starts_with($this->image, 'http')) {
        return $this->image;
    }
    
    // Sinon, retourne l'URL avec Storage
    return Storage::disk('public')->url($this->image);
}
public function getImageAttribute()
{
    if ($this->attributes['image']) {
        return env('APP_URL') . '/storage/' . $this->attributes['image'];
    }
    return null;
}
}
