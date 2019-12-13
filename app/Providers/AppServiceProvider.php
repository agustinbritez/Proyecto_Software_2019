<?php

namespace App\Providers;

use App\Configuracion;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    Schema::defaultStringLength(191);
    $configuracion = Configuracion::where('seleccionado', true)->first();
    View::share('configuracion',$configuracion);

    }
}
