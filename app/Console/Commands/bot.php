<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\TipoTweet;

class bot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ejecuta:bot';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta el bot de totanawarbot';
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
        //Se obtiene una plantilla aleatoria para la generación del tweet
        $tipoTweet = TipoTweet::inRandomOrder()->first();
        if($tipoTweet){
            $texto = $tipoTweet->contenido;
            //Obtenemos un usuario verificado y vivo como victima
            $victima = Usuario::where([
                                ["verificado", 1],
                                ["vivo", 1]
                ])->inRandomOrder()->first();
            $asesino = null;
            if($tipoTweet->asesinos > 0){
                $asesino = Usuario::where([
                            ["verificado", 1],
                            ["vivo", 1]
                    ])->inRandomOrder()->first();
            }
        }
        
    }
}
