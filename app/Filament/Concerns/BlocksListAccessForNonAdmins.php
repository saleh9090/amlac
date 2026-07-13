<?php

namespace App\Filament\Concerns;

trait BlocksListAccessForNonAdmins
{
    /**
     * Filament's ListRecords page does not automatically enforce
     * canViewAny() the way Create/Edit pages enforce canCreate()/
     * canEdit() — so direct URL access needs an explicit check here.
     */
    protected function authorizeAccess(): void
    {
        abort_unless(static::getResource()::canViewAny(), 403);
    }
}
