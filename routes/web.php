<?php

use App\Models\Contract;
use App\Models\Document;
use App\Support\BuildingAccess;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/admin/documents/{document}/download', function (Document $document) {
    abort_unless(in_array($document->building_id, BuildingAccess::allowedBuildingIds()), 403);

    return response()->download(
        Storage::disk('local')->path($document->file_path),
        $document->name.'.pdf',
    );
})->middleware(Authenticate::class)->name('documents.download');

Route::get('/admin/contracts/{contract}/download', function (Contract $contract) {
    abort_unless(filled($contract->contract_image), 404);
    abort_unless(in_array($contract->unit?->building_id, BuildingAccess::allowedBuildingIds()), 403);

    return response()->download(
        Storage::disk('local')->path($contract->contract_image),
        $contract->contract_number.'.pdf',
    );
})->middleware(Authenticate::class)->name('contracts.download');
