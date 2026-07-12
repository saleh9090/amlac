<?php

namespace App\Support;

class BuildingAccess
{
    /**
     * Admins always see every building; "user" role members only see
     * the building(s) assigned to them.
     */
    public static function isRestricted(): bool
    {
        $user = auth()->user();

        return $user !== null && ! $user->isAdmin();
    }

    /**
     * @return array<int, int>
     */
    public static function allowedBuildingIds(): array
    {
        $user = auth()->user();

        if (! $user || $user->isAdmin()) {
            return \App\Models\Building::query()->pluck('id')->all();
        }

        return $user->buildings()->pluck('buildings.id')->all();
    }
}
