<?php

namespace Modules\Correio\Http\Controllers;


use App\Jobs\AtualizarRastreio;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Correio\Entities\{Correio};
use PhpQuery\PhpQuery as phpQuery;
use DOMDocument;
use DOMXPath;
use NotificationChannels\Twitter\TwitterDirectMessage;
use Twitter;



class CorreioController extends Controller
{
    protected $moduleInfo;
    protected $menu;

    public function  __construct(){
        $this->moduleInfo = [
            'icon' => 'store',
            'name' => 'CORREIO',
        ];
        $this->menu = [
           
            ['icon' => 'location_searching', 'tool' => 'Rastrear objeto', 'route'=>'/correio'],
        ];
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */

   

    public function index()
    {
        $moduleInfo = $this->moduleInfo;
        $menu = $this->menu;
        $correio = Correio::all();     
        $data = [
           'url'=> url('correio/correio'),           
           'title' => 'Lista de Objetos Recentemente Pesquisados',
           'icon' => 'store',
           'name' => 'Correio',
           "model" => null,
           'correio'=> Correio::all(),
                
        ]; 
            
        return view('correio::correio.home', compact('data','moduleInfo','menu','correio'));
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {   $linhas = 0;
        $moduleInfo = $this->moduleInfo;
        $menu = $this->menu;
        $dadosCorreio = $this->dadosCorreio($request->input('codigo'));
        $regex = "/([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})/";
        $link = "https://apps.correios.com.br/cas/login?service=http%3A%2F%2Fwww2%2Ecorreios%2Ecom%2Ebr%2Fsistemas%2Frastreamento%2Flogin%2Ecfm";      
        $aux = true;
        $aux1 = false;
        $lastUpdate = $this->ultimaAtualizacao($request->input('codigo'));
         
                
        if (preg_match($regex, $request->input('codigo'))) {
                        $aux1 = true;
                
        }elseif ($dadosCorreio == null){   
            $aux = false;
        }
         
        $data = [
            "url"       => url('correio/rastrear'),
            "button"    => "Rastrear",
            "model"     => null,
            'title'     => "Buscar novo Objeto",
            'model'     => '',
            'correio'   => Correio::all(),           
            'codigo' => $request->input('codigo')            
            
        ];            
        
         return view('correio::correio.buscar_objeto', compact('data','moduleInfo','menu','aux','dadosCorreio','linhas','link','aux1','lastUpdate'));       
    }



        /*Essa função recebe o codigo do objeto a ser rastreado
          e retorna um array muntidimensional o contendo as informações do ratreio
          já formatadas*/

     public function dadosCorreio($codigo)
        {
          $dados = [];
        
          if($codigo) {    
        
        //Parametros que serão enviados para requisição

            $post = [
            'P_LINGUA' => 101,
            'P_TIPO' => 'L',
            'objetos' => $codigo
            ];
        
            $config = [
                'useragent'   => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36',
                'referer'     => 'https://www2.correios.com.br/sistemas/rastreamento/resultado.cfm?',
                'url'         => 'https://www2.correios.com.br/sistemas/rastreamento/resultado.cfm?'
            ];

        /*Criando um objeto curl e setando parametros para fazer a requisição
          no WebService dos correios*/
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $config['url'] );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query($post) );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch, CURLOPT_USERAGENT, $config['useragent'] );
            curl_setopt( $ch, CURLOPT_REFERER, $config['referer'] );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION,  true);
      
        /*Executando a requisição e tranformando
          a response em um DOMDocument*/    

            $resposta = curl_exec( $ch );
            //var_dump($resposta);
            $htmldoc = new DOMDocument();
            libxml_use_internal_errors(true);
            $htmldoc->loadHTML($resposta);
            $xpath = new DOMXPath($htmldoc);
        
        
        /*O primeiro foreach busca no DOMDocument as linhas da tabela que contem 
         as informações as sobre o ratreio pela sua classe e as insere em um
         array multdimensional a primeira dimensão recebe as linhas da tabela, o
         segundo foreach formata o conteudo das celulas das linhas e as insere
         na segunda dimensão do array.*/  

            $aux = $xpath->query('//table[@class="listEvent sro"]//tr');


            if ($aux) {           
        
                foreach($xpath->query('//table[@class="listEvent sro"]//tr') as $key_tr => $tr){
                    $dados[$key_tr] = [];        
                    $tds = $xpath->query("./td", $tr);

                    foreach($tds as $key_td => $td){
                        $dados[$key_tr][] = $this->formatText($td->textContent);
                 }
            }

            //$info = $dados[0][0];
            return $dados;   

            
          }
          return null;
                
                            
       
        }else {
           return false;
        }
}

public function ultimaAtualizacao($codigo) {
    
    $tabela = $this->dadosCorreio($codigo);    
    if ($tabela == null) {
        return false; 
    }else{
    $dados = $tabela[0];
    return $dados;
  }

}

//Essa função recebe a tabela com as informções do ratreio 
//em formato de string e a retorna formatada pronta para ser exibida    

function formatText($table){
    return preg_replace(['(\s+)u', '(^\s|\s$)u'], [' ', ''], $table);
}


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
public function store(Request $request)
{
        $dado = Correio::all();
        $linha = $this->dadosCorreio(request('objeto'));
        $linhas = count($linha);
        
       $data = [

        'descricao' => request('descricao'),
        'objeto' => request('objeto'),
        'isToNotify' => request('isToNotify'),
        'isToNotifyTw' => request('isToNotifyTw'),
        'ultimaAtualizacao' => request('ultimaAtualizacao'),
        'linhas'=> $linhas
        
       
        
        
    ];
        

    foreach ($dado as $aux) {           
         
        if ($aux->objeto == request('objeto')) {
            return back()->with('error','Este objeto ja foi salvo anteriormente');
       }
    } 
    try{
        Correio::create($data);
        return redirect('correio')->with('success', 'Objeto cadastrado com successo');
    }catch(Exception $e){
        DB::rollback();
        return back()->with('error', 'Erro no servidor');
    }
}

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Request $request, Correio $correio)
    {   
      // $tabelas = ToBeNotified::dispatchNow();       
      // AtualizarRastreio::dispatchNow();
       
       $correio = Correio::find($request->input('id'));
       $correio->isToNotify = $request->input('isToNotify');
       $correio->descricao = $request->input('descricao');
       $correio->save();
  
               
        return back()->with('success',  'Objeto atualizado');

        
    }

     public function atualizar()
    {   
      // $tabelas = ToBeNotified::dispatchNow();       
       AtualizarRastreio::dispatchNow();   

        
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('correio::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
       $correio = Correio::find($request->input('id'));
       $correio->isToNotify = $request->input('isToNotify');
       $correio->descricao = $request->input('descricao');
       $correio->save();
  
               
        return back()->with('success',  'Objeto atualizado');

    }

     public function toTwitter($id, $message)
    {
     return new TwitterDirectMessage($id, $message);
    }



   

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $c = Correio::findOrFail($id);
        $c->delete();
        return back()->with('success',  'Objeto deletado');
    }
}
