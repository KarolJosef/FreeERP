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


class AtualizarRastreio implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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

         //Verifico se existe objetos a serem pesquisados na tabela Correio
        $tabela = Correio::where('isToNotify',1)->get();
        //Se houver resulado
        if (count($tabela) !=0 ) {           
            $controler = new CorreioController;            
        //Nessa iteração cada posição do array $results recebe o resultado da busca de cada objeto a ser rastreado.
             for ($i = 0; $i < count($tabela); $i++) {
                     $results[$i] = $controler->dadosCorreio($tabela[$i]->objeto);
                     if(count($results[$i]) > $tabela[$i]->linhas){
                        $correio = Correio::findOrFail($tabela[$i]->id);
                        $correio->linhas = count($results[$i]);
                        $correio->save();
                        Mail::to('karoljozef123@hotmail.com')->send(new RastreamentoEmail($results[$i]));
                        print_r("linhas atualizadas ");

                    }
          /*  foreach ($tabela as $dado) {
                     $results = $controler->dadosCorreio($dado->objeto);
                     if(count($results) > $dado->linhas){
                        $correio = Correio::findOrFail($dado->id);
                        $correio->linhas = count($results);
                        $correio->save();
                        Mail::to('leandroramos@usp.br')->send(new RastreamentoEmail($results)
                        );
                        print_r("linhas atualizadas");

                    }
                   }
            */
            
            
        }}else{
          return false;
        }
    }    
}
