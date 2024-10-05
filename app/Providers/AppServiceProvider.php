<?php

namespace App\Providers;

use App\Services\AvatarService;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $avatarService = new AvatarService;

        $this->app->instance(AvatarService::class, $avatarService);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Collection::macro('addCreatedAgo', function () {
            return $this->transform(fn ($item) => [
                ...$item->toArray(),
                'created_ago' => $item->created_at->diffForHumans(),
            ]);
        });
    }
}
