<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Enums\VC_ChargiesEnum;

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
        $vcChargies = collect(VC_ChargiesEnum::cases())
            ->mapWithKeys(fn($case) => [
                $case->name => [
                    'value' => $case->percentage(),
                ]
            ])
            ->toArray();

        View::share('vcChargesEnum', $vcChargies);
    }
}
