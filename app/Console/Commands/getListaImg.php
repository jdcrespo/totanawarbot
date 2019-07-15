<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;

class getListaImg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imagen:alistados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtiene todos los alistados y los almacena en la BBDD';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       Usuario::getImagenEstado("images/listado.jpg", false);
    }
}
