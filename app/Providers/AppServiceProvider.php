<?php

namespace App\Providers;

use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Filament\Tables\View\TablesRenderHook;

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
        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
            fn (): View => view('hooks.login-before'),
        );

        /*FilamentView::registerRenderHook(
            TablesRenderHook::SELECTION_INDICATOR_ACTIONS_BEFORE,
            fn (): View => view('hooks.compras-before'),
        );*/

        FilamentView::registerRenderHook(
            PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_BEFORE ,
            fn (): View => view('hooks.message', [
                'message' => 'Debajo de este texto puede ver todas las compras que se van a realizar en los proximos dias. Seleccione una en estado "Activa" para cargar su pedido.'
            ]),
            scopes: \App\Filament\Resources\ComprasResource\Pages\ListCompras::class,
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_BEFORE ,
            fn (): View => view('hooks.message', [
                'message' => 'Debajo de este texto puede ver todos los pedidos realizados por todos los usuarios hasta el momento.<br> Para cargar un pedido aprete el boton Nuevo Pedido.'
            ]),
            scopes: \App\Filament\Resources\ComprasResource\Pages\ViewCompras::class
        );
    }
}
