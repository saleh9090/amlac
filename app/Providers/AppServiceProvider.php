<?php

namespace App\Providers;

use App\Policies\ReadOnlyAwarePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::guessPolicyNamesUsing(fn (string $modelClass): string => ReadOnlyAwarePolicy::class);
    }
}
