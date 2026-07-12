<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ReadOnlyAwarePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Model $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return ! $user->is_read_only;
    }

    public function update(User $user, Model $record): bool
    {
        return ! $user->is_read_only;
    }

    public function delete(User $user, Model $record): bool
    {
        return ! $user->is_read_only;
    }

    public function deleteAny(User $user): bool
    {
        return ! $user->is_read_only;
    }

    public function forceDelete(User $user, Model $record): bool
    {
        return ! $user->is_read_only;
    }

    public function forceDeleteAny(User $user): bool
    {
        return ! $user->is_read_only;
    }

    public function restore(User $user, Model $record): bool
    {
        return ! $user->is_read_only;
    }

    public function restoreAny(User $user): bool
    {
        return ! $user->is_read_only;
    }

    public function replicate(User $user, Model $record): bool
    {
        return ! $user->is_read_only;
    }

    public function reorder(User $user): bool
    {
        return ! $user->is_read_only;
    }
}
