<?php

namespace App\Providers;

use App\Models\Lahan;
use Illuminate\Support\ServiceProvider;

class UpdateStatusProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $year = date('Y');
        $year = intval($year);
        $data = Lahan::all();
    }
}
