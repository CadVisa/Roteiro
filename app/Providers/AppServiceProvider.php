<?php

namespace App\Providers;

use App\Models\Card;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Models\Configuration;

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
        Paginator::useBootstrapFive();

        if (!Session::has('config')) {
            $config = Configuration::first();
            Session::put('config', $config);
        }

        if (!Session::has('cards')) {
            $cards = Card::where('card_status', 'Ativo')
                ->orderBy('card_ordem')
                ->get();
            Session::put('cards', $cards);
        }
    }
}
