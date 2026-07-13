<?php

namespace App\Filament\Concerns;

trait RestrictedToAdmins
{
    /**
     * Hidden from navigation AND blocked from direct URL access for the
     * read-only "user" role — only Admins can reach this resource.
     */
    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }
}
