<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\SelectProvincia;
use App\View\Components\SelectRangoEdad;
use App\View\Components\SelectDepartamento;
use App\View\Components\SelectEducacion;
use App\View\Components\SelectExperiencia;
use App\View\Components\SelectLocalidad;
use App\View\Components\SelectPerfil;
use App\View\Components\SelectSituacion;
use App\View\Components\SelectSector;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ...existing code...
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ...existing code...
    }
}
