<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Facades\Filament;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Notifications\UserRegisteredEmail;
use App\Filament\Resources\UserResource;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasRoles;

class User extends Authenticatable
// implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    const ROLE_ADMIN = "admin";
    const ROLE_AUTHOR = "author";
    const ROLE_USER = "user";

    const ROLES = [
        self::ROLE_ADMIN => 'admin',
        self::ROLE_AUTHOR => 'author',
        self::ROLE_USER => 'user',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'NIK',
        'name',
        'role',
        'email',
        'password',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for arrays and JSON.
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

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }



    /**
     * Boot the model and auto-fill created_by / updated_by.
     */
    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (Filament::auth()->user()) {
                $model->created_by = Filament::auth()->user()->name;
                $model->updated_by = Filament::auth()->user()->name;
            }
        });

        static::updating(function ($model) {
            if (Filament::auth()->user()) {
                $user = Filament::auth()->user();
                $changed = [];

                $plainPassword = $model->password_plain;

                foreach ($model->getDirty() as $key => $value) {
                    $original = $model->getOriginal($key);

                    if ($key === 'password') {
                        if (!filled($plainPassword) || Hash::check($plainPassword, $original)) {
                            continue; // hash baru tapi password sama
                        } else {
                            $changed[] = "$key";
                            continue;
                        }
                    }
                    if (in_array($key, ['remember_token', 'two_factor_secret', 'two_factor_recovery_codes'])) {
                        continue;
                    }

                    $changed[] = "$key: '$original' → '$value'";
                }

                // Jika ada perubahan penting, catat ke updated_by dan keterangan
                if (count($changed) > 0) {
                    $model->updated_by = $user->name . ' (' . $user->NIK . ')';
                    $model->keterangan = 'Change: ' . Str::limit(implode(', ', $changed), 255);
                } else {
                    // Jangan ubah nilai yang ada di DB
                    $model->updated_by = $model->getOriginal('updated_by');
                    $model->keterangan = $model->getOriginal('keterangan');
                }
            }
        });
    }
    /**
     * Mengizinkan semua pengguna mengakses panel Filament
     * Pengecekan lebih detail dilakukan di middleware dan login
     *
    //  * @param Panel $panel
    //  * @return bool
    //  */
    // // public function canAccessPanel(Panel $panel): bool
    // // {
    // //     return true; // Akses panel dikelola oleh middleware CheckModuleAccess
    // // }

    public string|null $password_plain = null;
}
