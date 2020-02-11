<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Modules\Correio\Entities\{Correio};
use Modules\Correio\Http\Controllers\CorreioController;
use App\Mail\RastreamentoEmail;
use Illuminate\Support\Facades\Mail;
use App\Notifications\newWasPublished;
use Illuminate\Foundation\Auth\Correio as Authenticatable;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\Twitter\TwitterDirectMessage;
use Twitter;
use Abraham\TwitterOAuth\TwitterOAuth;
class AtualizarRastreio  implements ShouldQueue
{
    use Notifiable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
   
    public $results=[];
    

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       $data = $this->toBeNotified();

    }

     public function toBeNotified()
    {
            
            $user_id = '1204575743604330502';            
            $text    = 'Rastreamento de objeto atualizado clique aqui para verificar';
            $consumer='sKwp5haIsV2pbUXSaG91y8bYX';
            $consumer_secret='G9vwwHqZDwM9SzIFOtXFmzW34lILcViapJeVgxNZNN3JeMWWdS';
            $access_token='1723579946-IhAVJcrT6jxCovWG2MhyTbry3meh4MSK24lIDcH';
            $access_token_secret='71LVBuwQEm9YVtP5gui3E2tiWkDbM2dRRbbvIFiMEBT6P';
    
     
     $data1 =[
            'event' => [
                
              'type'=>'message_create', 
              'message_create' => [              
                'target' => ['recipient_id' =>$user_id ],
                'message_data' => ["text" => $text]
             ]
                    
            ]    
            
        ];          

         
         //Verifico se existe objetos a serem pesquisados na tabela Correio
          $tabela  = Correio::where('isToNotify',1)->get();

          $tabelaT = Correio::where('isToNotifyTw',1)->get();
          //print_r($tabela);
        //Se houver resulado
        if ((count($tabela)) !=0 || (count($tabelaT)) !=0 ) {           
            $controler = new CorreioController;            
        //Nessa iteração cada posição do array $results recebe o resultado da busca de cada objeto a ser rastreado.
             for ($i = 0; $i < count($tabela); $i++) {
                     $results[$i] = $controler->dadosCorreio($tabela[$i]->objeto);
                     if(count($results[$i]) > $tabela[$i]->linhas){
                        $correio = Correio::findOrFail($tabela[$i]->id);
                        $correio->linhas = count($results[$i]);                      
                    //  $correio->save();
                        Mail::to('karoljozef123@hotmail.com')->send(new RastreamentoEmail($results[$i]));            
                        print_r("linhas atualizadas ");

                    }
                   } 
         
            for ($i=0; $i < count($tabelaT); $i++) { 
                   $results[$i] = $controler->dadosCorreio($tabelaT[$i]->objeto);
                   if (count($results[$i]) > $tabelaT[$i]->linhas) {
                        $correio = Correio::findOrFail($tabelaT[$i]->id);
                        $correio->linhas = count($results[$i]);
                        $correio->save();
                        $conection = new TwitterOAuth($consumer, $consumer_secret, $access_token,$access_token_secret);
                      //$content = $conection->get("account/verify_credentials");
                        $result = $conection->post('direct_messages/events/new', $data1, true);
                        var_dump($result);
                      }   
            }
            
        



    }else{
          return false;
        }
    }    
}
