<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Twitter;

class Usuario extends Model
{

	protected $guarded = [];

	const ID_TWEET_ALISTAMIENTO = "1145694000772370434";
	const NOMBRE_CUENTA_BOT = "TotanaWarBot";
    
    const RESOLUCION_X_IMAGE = 1080;
    const RESOLUCION_Y_IMAGE = 1080;

    public static function getAlistamiento(){
    	$encontrados = array();

    	$searchData = [	"q" => "#totanaWB", 
    					"count" => 100, 
    					'format' => 'json'];

    	$data = Twitter::getSearch($searchData);
    	$data = json_decode($data);

    	$buscando = true;
    	$n = 0;
    	$totalLeidos = 0;
    	while($buscando && $data){
    		if(isset($data->search_metadata) && isset($data->search_metadata->next_results)){
    			$next_max_id = str_replace("&q", "", explode("=",$data->search_metadata->next_results)[1]);
    		}else{
    			$buscando = false;
    		}
	    	$since_id = -1;
	    	$max_id = -1;
	    	foreach ($data->statuses as $status) {
	    		
	    		if($status->in_reply_to_status_id_str == self::ID_TWEET_ALISTAMIENTO
	    			&& $status->in_reply_to_screen_name == self::NOMBRE_CUENTA_BOT){

	    			$userBuscado = Usuario::where("nombre", $status->user->screen_name)->first();
	    			if(!$userBuscado){
	    				$validado = (strtolower($status->user->location) == "totana") ||
	    							(strpos(strtolower($status->user->location), "totana") !== false);
	    				$userBuscado = new Usuario([
	    						"nombre" =>  $status->user->screen_name,
	    						"twitter_user_id" => $status->user->id_str,
	    						"ciudad" => $status->user->location,
	    						"validado" => ($validado ? 1 : 0),
	    						"validado_por" => ($validado ? "bot" : null)
	    				]);
	    				$userBuscado->save();
	    			}

	    			$encontrados[$status->user->id_str] = ["nombre" => $status->user->screen_name,
	    												"ciudad" => $status->user->location];
	    		}
	    		if($since_id == -1 || $since_id < $status->id){
	    			$since_id = $status->id;
	    		}
	    		if($max_id == -1 || $max_id > $status->id){
	    			$max_id = $status->id;
	    		}
	    		$totalLeidos++;
	    	}
	    	$searchData['max_id'] = $next_max_id;
	    	$data = Twitter::getSearch($searchData);
    		$data = json_decode($data);
    		if($buscando && $data && $data->search_metadata->count > 0 && $n < 4){
    			$buscando = true;
    		}else{
    			$buscando = false;
    		}
    		$n++;
	    }
    	return $encontrados;
    }
    
    
    public static function getImagenEstado($rutaImagenes){
        $fontSize = 24;
        $margin = 5;
        
        $usuarios = Usuario::where("validado", 1)->get();   
        $img = Image::canvas(self::RESOLUCION_X_IMAGE, self::RESOLUCION_Y_IMAGE, "#fff");
        
        if($img && $usuarios){
            foreach($usuarios as $usuario){
                $color = "#000000";
                if($usuario->vivo == 0){
                    $color = "#ff0000";   
                }
                $img->text('@'.$usuario->nombre, 0, 0, function($font) {
                    $font->size($fontSize);
                    $font->color($color);
                    $font->align('center');
                });        
            }            
        }
                
        $img->save(public_path($rutaImagenes));
    }
}
