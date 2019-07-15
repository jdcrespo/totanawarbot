<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\TipoTweet;
use App\Models\MuerteTweet;
use App\Models\Usuario;
use Twitter;
use File;
use Carbon\Carbon;

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
        //Se obtiene una plantilla aleatoria para la generación del tweet que no se haya usado durante el día de hoy
        $tipoTweet = TipoTweet::where("usado", "<", Carbon::now()->subDays(2))
                                ->inRandomOrder()
                                ->first();
        if($tipoTweet){
            $texto = $tipoTweet->contenido;
            //Obtenemos un usuario verificado y vivo como victima
            $victima = Usuario::where([
                                ["validado", 1],
                                ["vivo", 1]
                ])->inRandomOrder()->first();
            // Si es necesario un asesino lo obtemos de igual forma pero excluyendo a la victima
            $asesino = null;
            if($tipoTweet->asesinos > 0 && $victima){
                $asesino = Usuario::where([
                            ["validado", 1],
                            ["vivo", 1],
                            ["id", "!=", $victima->id]
                    ])->inRandomOrder()->first();
            }

            $tipoTweet->usado = Carbon::now();
            $tipoTweet->save();
            
            // Actualizamos el estado de la victima y el asesino si lo hubiera
            $victima->vivo = 0;
            $victima->save();
            
            if($asesino){
                $asesino->asesinatos_cometidos = $asesino->asesinatos_cometidos + 1;
                $asesino->save();                
            }
            
            // Preparamos el contenido del tweet
            if($victima){
                $texto = str_replace("[VICTIMA]", $victima->nombre, $texto);
            }
            if($asesino){
                $texto = str_replace("[ASESINO]", $asesino->nombre, $texto);
            }
            
            if($victima && strpos($texto, "[VICTIMA]") === false && strpos($texto, "[ASESINO]") === false){
                    // Generamos la imagen con todos los nombre y el estado atual
                    $nombreImagen = "images/".date("YmdHis").".jpg";
                    Usuario::getImagenEstado($nombreImagen);

                    // Almacenamos la muerte en la base de datos
                    $muerte = new MuerteTweet([
                                    "texto" => $texto,
                                    "imagen" => $nombreImagen
                     ]);
                    $muerte->save();

                    // Subimos la imagen y el tweet
                	$uploaded_media = Twitter::uploadMedia(['media' => File::get(public_path($nombreImagen))]);
	                Twitter::postTweet([
                            'status' => $texto, 
                            'format' => 'json',
                            'media_ids' => $uploaded_media->media_id_string
                        ]);
            }
        }

    }
}
