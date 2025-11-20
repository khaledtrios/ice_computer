<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Boutique;
use App\Models\Modele;
use App\Service\ModeleObserver;
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

        Modele::observe(ModeleObserver::class);

        View::composer('*', function ($view) {
            if (Auth::check() && Auth::user()->hasRole('boutique')) {
                $boutique = Boutique::where('user_id', Auth::id())->first();

                if ($boutique) {
                    $notifications = Notification::where('boutique_id', $boutique->id)
                        ->where('is_oppen', false)
                        ->orderBy('created_at', 'desc') 
                        ->get();

                    $view->with([
                        'config_type' => $boutique->config_type ?? null,
                        'boutique' => $boutique,
                        'notifications' => $notifications,
                    ]);
                }
            } elseif (Auth::check() && Auth::user()->hasRole('superadmin')) {
                $notifications = Notification::whereNull('boutique_id')
                    ->where('is_oppen', false)
                    ->orderBy('created_at', 'desc') 
                    ->get();

                $view->with([
                    'notifications' => $notifications,
                ]);
            }
        });

    }

}
