<?php

namespace berkay\statistics\providers;



use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;


Class StatisticsServiceProvider extends ServiceProvider
{

    public function boot()
    {

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../views', 'Statistics');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $data = [
            'baslik' => 'İstatistikler',
            'url' => '/yonetim/statistics',
            'aktif_mi' => 1
        ];

        $count = DB::table('moduller')->where('Baslik', 'Projeler')->count();

        if ($count == 0) {
            DB::table('moduller')->insert($data);
        } else {
            return false;
        }


    }

    public function register()
    {

    }


}
