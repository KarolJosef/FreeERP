public function toBeNotified()
    {
        //Verifico se existe objetos a serem pesquisados na tabela Correio
        $tabela = Correio::where('isToNotify',1)->get();
        //Se houver resulado
        if (count($tabela) !=0 ) {
           
            $controler = new CorreioController;
            
           //Nessa iteração cada posição do array $results recebe o resultado da busca de cada objeto a ser pesquisado.
            foreach ($tabela as $dado) {
                     $results = $controler->dadosCorreio($dado->objeto);
                     if(count($results) > $tabela->linha){
                        $correio = Correio::findOfFail($dado->id);
                        $correio->linhas = count($results);
                        $correio->save();
                        print_r("linhas atualizadas");


                   }
            }
        }else{
          return false;
        }

        return $results;                                  
        // var_dump($results);   
    }