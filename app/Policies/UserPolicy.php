<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Tentukan apakah user bisa melihat daftar user (hanya 2).
     */
    public function viewAny(User $user): bool
    {
        return $user->role === '2' || $user->role === '1';
    }

    /**
     * Tentukan apakah user bisa melihat data user tertentu.
     */
    public function view(User $user, User $model): bool
    {
        return $user->role === '2' || $user->role === '1' || $user->id === $model->id;
    }

    /**
     * Tentukan apakah user bisa mengupdate data user tertentu.
     */
    public function update(User $user, User $model): bool
    {
        // Tidak ada yang bisa mengedit 1 kecuali 1 sendiri
        if ($model->role === '1' && $user->role !== '1') {
            return false;
        }

        // 2 tidak boleh mengedit 2 lain
        if ($model->role === '2' && $user->role === '2' && $user->id !== $model->id) {
            return false;
        }

        // 1 bisa update siapa saja, termasuk sesama 1
        if ($user->role === '1') {
            return true;
        }

        // 2 bisa update semua kecuali 1
        if ($user->role === '2') {
            return true;
        }

        // User biasa hanya boleh update dirinya sendiri
        return $user->id === $model->id;
    }


    /**
     * Tentukan apakah user bisa mengupdate email.
     */
    public function updateEmail(User $user, User $model): bool
    {
        // Hanya 1 bisa ubah email
        return $user->role === '1';
    }

    /**
     * Tentukan apakah user bisa mengupdate NIK.
     */
    public function updateNik(User $user): bool
    {
        // Hanya 2 bisa ubah NIK
        return $user->role === '1';
    }

    /**
     * Tentukan apakah user bisa mengupdate role.
     */
    public function updateRole(User $user, User $model): bool
    {
        return $user->role === '2' || $user->role === '1';
    }

    /**
     * Tentukan apakah user bisa menghapus user (hanya 2).
     */
    public function delete(User $user, User $model): bool
    {
        return $user->role === '1';
    }
}
