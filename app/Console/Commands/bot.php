<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\TipoTweet;
use App\Models\MuerteTweet;

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
            // Si es necesario un asesino lo obtemos de igual forma pero excluyendo a la victima
            $asesino = null;
            if($tipoTweet->asesinos > 0 && $victima){
                $asesino = Usuario::where([
                            ["verificado", 1],
                            ["vivo", 1],
                            ["id", "!=", $victima->id]
                    ])->inRandomOrder()->first();
            }
            
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
                    $nombreImagen = "images/".date("Ymd").".jpg";
                    Usuario::getImagenEstado($nombreImagen);
                    // $muerte = new MuerteTweet([
                    //                "texto" => $texto,
                    //                "imagen" => $nombreImagen
                    // ]);
                	// $uploaded_media = Twitter::uploadMedia(['media' => File::get(public_path($nombreImagen))]);
	                // Twitter::postTweet(['status' => $texto, 'media_ids' => $uploaded_media->media_id_string]);
            }
        }
        
    }
}
