<?php

namespace Lupita\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Lupita\Afiliacion;
use Lupita\Afiliaciondetalle;
use Lupita\Empresa;
use Lupita\Prestamo;
use Lupita\Prestamodetalle;
use Lupita\Tasacambio;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

       //Afiliacion
       $schedule->call('Lupita\Http\Controllers\AfiliacionController@cronafiliacion')->monthlyOn(15, '10:59');
       $schedule->call('Lupita\Http\Controllers\AfiliacionController@cronafiliacion')->monthlyOn(date('t'), '09:05');

       //Anticipo
       $schedule->call('Lupita\Http\Controllers\PrestamoController@cronanticipo')->monthlyOn(15, '11:22');


       //Prestamo Quincenal - dia 15
       $schedule->call('Lupita\Http\Controllers\PrestamoController@cronprestamoq')->monthlyOn(15, '10:15');

       //Prestamo Quincenal - Fin del mes
       $schedule->call('Lupita\Http\Controllers\PrestamoController@cronprestamoq')->monthlyOn(30, '10:09');

       // Prestamo mensual - pagos quincenales
       $schedule->call('Lupita\Http\Controllers\PrestamoController@cronprestamom')->monthlyOn(15, '11:41');

       //Febrero
       $schedule->call('Lupita\Http\Controllers\PrestamoController@cronprestamom')->cron('20 15 28 2 *');
       $schedule->call('Lupita\Http\Controllers\PrestamoController@cronprestamoq')->cron('22 15 28 2 *');

       // Prestamo mensual - pagos dia 30
       $schedule->call('Lupita\Http\Controllers\PrestamoController@cronprestamom')->monthlyOn(30, '10:09');

       //Ahorro
       $schedule->call('Lupita\Http\Controllers\AhorroController@cronahorrom')->monthlyOn(date('t'), '09:05');
       $schedule->call('Lupita\Http\Controllers\AhorroController@cronahorroq')->monthlyOn(15, '10:59');

       //Deuda Empresa (detalles)
       $schedule->call('Lupita\Http\Controllers\DeudaempresaController@cronafdeudaemp')->monthlyOn(date('t'), '10:14');
       $schedule->call('Lupita\Http\Controllers\DeudaempresaController@cronafdeudaemp')->monthlyOn(15, '10:59');

       //Cartera Deuda Empresa (resumen)
       $schedule->call('Lupita\Http\Controllers\CarteraController@croncartera')->monthlyOn(date('t'), '10:15');
       $schedule->call('Lupita\Http\Controllers\CarteraController@croncartera')->monthlyOn(15, '10:59');

       //Plazo fijo detalles
       $schedule->call('Lupita\Http\Controllers\PlazofijodetalleController@cronplazofijomen')->monthlyOn(date('t'), '09:05');
       $schedule->call('Lupita\Http\Controllers\PlazofijodetalleController@cronplazofijopay')->dailyAt('17:19');
       $schedule->call('Lupita\Http\Controllers\PlazofijodetalleController@cronplazofijomenvecimiento')->dailyAt('13:25');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
