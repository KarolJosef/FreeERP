<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Modules\Correio\Entities\{Correio};

use App\Console\Commands\ToBeNotified;


class VerificaAtualizacao implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $var = ToBeNotified::DispatchableNow();

        $tabela = Correio::where('isToNotify',1)->get();
        var_dump(count($var[1]));

       if (count($dados)!=0) {
            
            foreach ($var as $dado) {
                    if ($var->linhas > $tabela->linhas) {
                        return "entrei";
                    }else{
                        return "me lasquei";
                    }
            }
        } 
    }
}
