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
       $schedule->call('Lupita\Http\Controllers\AfiliacionController@cronafiliacion')->monthlyOn(15, '14:40');
       $schedule->call('Lupita\Http\Controllers\AfiliacionController@cronafiliacion')->monthlyOn(date('t'), '14:20');

       //Pretamo Quincenal - dia 15
       $schedule->call('Lupita\Http\Controllers\PrestamoController@cronprestamoq')->monthlyOn(15, '11:40');

       //Pretamo Quincenal - Fin del mes
       $schedule->call('Lupita\Http\Controllers\PrestamoController@cronprestamoq')->monthlyOn(date('t'), '14:20');

       // Prestamo mensual - pagos quincenales
       $schedule->call('Lupita\Http\Controllers\PrestamoController@cronprestamom')->monthlyOn(15, '11:40');

       // Prestamo mensual - pagos ultimo dia del mes
       $schedule->call('Lupita\Http\Controllers\PrestamoController@cronprestamom')->monthlyOn(date('t'), '14:20');

       //Ahorro - Finales del mes
       $schedule->call('Lupita\Http\Controllers\AhorroController@cronahorrom')->monthlyOn(date('t'), '14:20');
       $schedule->call('Lupita\Http\Controllers\AhorroController@cronahorroq')->monthlyOn(15, '11:40');

       //Deuda Empresa (detalles)
       $schedule->call('Lupita\Http\Controllers\DeudaempresaController@cronafdeudaemp')->monthlyOn(date('t'), '14:20');
       $schedule->call('Lupita\Http\Controllers\DeudaempresaController@cronafdeudaemp')->monthlyOn(15, '11:40');

       //Cartera Deuda Empresa (resumen)
       $schedule->call('Lupita\Http\Controllers\CarteraController@croncartera')->monthlyOn(date('t'), '10:56');
       $schedule->call('Lupita\Http\Controllers\CarteraController@croncartera')->monthlyOn(15, '10:56');

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
