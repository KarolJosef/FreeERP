<?php

namespace Modules\Estoque\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Estoque\Entities\Categoria;
use Modules\Estoque\Entities\Estoque;
use Modules\Estoque\Entities\MovimentacaoEstoque;
use Modules\Estoque\Entities\Produto;

use Modules\Estoque\Entities\TipoUnidade;

class EstoqueController extends Controller
{
    public $dadosTemplate;

    public function __construct()
    {
        $moduleInfo = [
            'icon' => 'store',
            'name' => 'Estoque',
        ];
        $menu = [
            ['icon' => 'shopping_basket', 'tool' => 'Produto', 'route' => url('/estoque/produto')],
            ['icon' => 'format_align_justify', 'tool' => 'Categoria', 'route' => url('/estoque/produto/categoria')],
            ['icon' => 'store', 'tool' => 'Estoque', 'route' => url('estoque')],
        ];
        $this->dadosTemplate = [
            'moduleInfo' => $moduleInfo,
            'menu' => $menu,
        ];
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

        $flag = 0;
        $notificacoes = $this->verificarNotificacoes();
        $itens = Estoque::paginate(10);
        return view('estoque::estoque.index', $this->dadosTemplate, compact('itens', 'flag', 'notificacoes'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $notificacoes = $this->verificarNotificacoes();
        $data = [
            'titulo' => 'Cadastrar Estoque',
            'button' => 'Cadastrar',
            'url' => 'estoque',
            'estoque' => null,
            'produtos' => Produto::all(),
            'tipoUnidade' => TipoUnidade::all(),
        ];

        return view('estoque::estoque.form', compact('data', 'notificacoes'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //   dd($request->all());

        //return $unidades;

        DB::beginTransaction();
        try {

            $estoque = Estoque::create($request->all());
            $produto = Produto::findOrFail($request->produto_id);
            $estoque->produtos()->attach($produto);
            $estoque->save();
            MovimentacaoEstoque::create(
                [
                    'estoque_id' => $estoque->id,
                    'quantidade' => $estoque->quantidade,
                    'preco_custo' => $request['preco_custo'],
                    'observacao' => "Entrada Inicial",
                ]
            );
            DB::commit();
            return redirect('/estoque')->with('success', 'Item de estoque registrado com sucesso!');
        } catch (Exception $ex) {
            DB::rollback();
            return back()->with('danger', "Erro ao tentar registrar item. cod:"+$ex->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('estoque::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {

        $notificacoes = $this->verificarNotificacoes();
        $estoque = Estoque::findOrFail($id);
        $idProduto = $estoque->produtos->last()->id;
        $data2 = array();
        $itens = DB::table('estoque')
            ->join('estoque_has_produto', function ($join) use ($idProduto) {
                $join->where('produto_id', $idProduto)->whereraw('estoque.id = estoque_has_produto.estoque_id');
            })->get();
        foreach ($itens as $item) {
            if ($item->tipo_unidade_id != $estoque->tipo_unidade_id) {
                $data2[] = $item->tipo_unidade_id;
            }
        }

        $data = [
            'button' => 'atualizar',
            'url' => 'estoque/' . $id,
            'titulo' => 'Editar Estoque',
            'estoque' => $estoque,
            'produtos' => Produto::withTrashed()->get(),
            'produto' => $estoque->produtos->last(),
            'tipoUnidade' => TipoUnidade::all()->except($data2),

        ];
        return view('estoque::estoque.form', compact('data', 'notificacoes'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $estoque = Estoque::findOrFail($id);

            $observacao = $this->verificaAlteracoes($request, $estoque);

            $qtdInicial = $estoque->quantidade;
            $qtdMovimentacao = $request['quantidade'] - $qtdInicial;
            $estoque->update($request->all());
            MovimentacaoEstoque::create(
                [
                    'estoque_id' => $estoque->id,
                    'quantidade' => $qtdMovimentacao,
                    'preco_custo' => $request['preco_custo'],
                    'observacao' => $observacao,
                ]
            );
            DB::commit();
            return redirect('/estoque')->with('message', 'Item de estoque atualizado com sucesso')->with('success', 'Item de estoque atualizado com sucesso');
        } catch (Exception $ex) {
            DB::rollback();
            return back()->with('warning', ' Erro ao atualizar item de estoque! cod:' . $ex);
        }
    }
    public function buscaUnidades(Request $request)
    {
        $data2 = array();
        $itens = DB::table('estoque')
            ->join('estoque_has_produto', function ($join) use ($request) {
                $join->where('produto_id', $request->id)->whereraw('estoque.id = estoque_has_produto.estoque_id');
            })->get();
        foreach ($itens as $unidade) {
            $data2[] = $unidade->tipo_unidade_id;
        }

        $unidades = TipoUnidade::all()->except($data2);
        return json_encode($unidades);
    }
    public function verificaAlteracoes($request, $estoque)
    {
        $observacao = "Este item foi atualizado \n";

        if (intval($request->tipo_unidade_id) != $estoque->tipo_unidade_id) {
            return "Request unidade id =" . intval($request->tipo_unidade_id) . "Produto Unidade id = " . $produto->unidade_id;
            $novaUnidade = TipoUnidade::find($request->tipo_unidade_id);

            $observacao .= "\n Alteração do tipo de unidade de " . $estoque->tipoUnidade->nome . " para " . $novaUnidade->nome;
        }
        if (floatVal($request->preco_custo) != floatVal($estoque->movimentacaoEstoque->last()->preco_custo)) {
            $observacao .= "\n . Alteração no preço de custo de " . $estoque->movimentacaoEstoque->last()->preco_custo . " para " . $request->preco_custo;
        }
        if ($request->quantidade != $estoque->quantidade) {
            $observacao .= " Quantidade alterada de " . $estoque->quantidade . " para " . $request->quantidade;
        }
        return $observacao;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $estoque = Estoque::findOrFail($id);

        MovimentacaoEstoque::create(
            [
                'estoque_id' => $estoque->id,
                'quantidade' => $estoque->quantidade,
                'preco_custo' => $estoque->preco_custo,
                'observacao' => "Item Excluido",
            ]
        );
        $estoque->delete();
        return back()->with('success', 'Categoria Removida com sucesso');
        //
    }
    public function restore($id)
    {
        $estoque = Estoque::onlyTrashed()->findOrFail($id);
        $estoque->restore();
        return redirect('/estoque')->with('success', 'Item restaurado com sucesso!');
    }
    public function inativos()
    {
        $flag = 1;
        $itensInativos = Estoque::onlyTrashed()->paginate(5);
        $notificacoes = $this->verificarNotificacoes();
        return view('estoque::estoque.index', $this->dadosTemplate, compact('notificacoes', 'itensInativos', 'flag'));
    }

    public function buscar(Request $request)
    {
        $flag = 0;
        $notificacoes = $this->verificarNotificacoes();
        if ($request->pesquisa == null) {
            $itens = Estoque::paginate(10);
            return view('estoque::estoque.index', $this->dadosTemplate, compact('itens', 'flag'))->with('success', 'Resultado da Pesquisa');
        } else {
            $itens = Estoque::join('estoque_has_produto', 'estoque_has_produto.estoque_id', '=', 'estoque.id')
                ->join('produto', 'produto.id', '=', 'estoque_has_produto.produto_id')
                ->where('produto.nome', 'like', '%' . $request->pesquisa . '%')->paginate(10);
            return view('estoque::estoque.index', $this->dadosTemplate, compact('notificacoes', 'itens', 'flag'))->with('success', 'Resultado da Pesquisa');
        }
    }

    public function notificacoes()
    {
        $itens = Estoque::where('quantidade', '<=', DB::raw('quantidade_notificacao'))->paginate(10);
        $notificacoes = $this->verificarNotificacoes();
        return view('estoque::estoque.notificacoes.index', compact('itens', 'notificacoes'));
    }
    public function saidaProdutos()
    {
        $data = [
            'produtos' => Produto::all(),
            'categorias' => Categoria::all(),
        ];
        return view('estoque::estoque.relatorios.saidaProdutos', compact('data'));
    }

    public static function verificarNotificacoes()
    {
        $itens = Estoque::where('quantidade', '<=', DB::raw('quantidade_notificacao'))->paginate(10);
        return count($itens);
    }

    public function relatorioCusto()
    {
        $query_result = DB::select(
            'SELECT distinct substring_index(created_at, " ", 1) as data,
            (SELECT nome FROM produto WHERE id = (SELECT produto_id FROM estoque_has_produto WHERE estoque_id = 3)) as nome,
            (SELECT SUM(quantidade*preco_custo) FROM movimentacao_estoque WHERE substring_index(created_at, " ", 1) = data AND estoque_id = 3 AND quantidade > 0) as qtd
             FROM movimentacao_estoque as me WHERE estoque_id = 3 order by data asc'
        );
        $labels = [];
        $dados = [];
        $data = [
            'estoque' => Estoque::all(),
            'labels' => json_encode($labels),
            'dados' => json_encode($dados),
            'flag' => "0"
        ];

        return view('estoque::estoque.relatorios.custo', compact('data'));
    }

    public function relatorioCustoBusca(Request $req)
    {
        //Se for para selecionar o período com todos os estoques
        $query_result = [];
        $movimentacao = [];
        $quantidade_movimentada = 0;
        $estoque_selecionado = "";
        $custo_total = "";
        if($req->estoque_id != -1)
            $estoque_selecionado = Estoque::findOrFail($req->estoque_id);
        if ($req->estoque_id == -1) {
            $query_result = DB::select(
                'SELECT distinct substring_index(created_at, " ", 1) as data,
                (SELECT SUM(quantidade*preco_custo) FROM movimentacao_estoque WHERE substring_index(created_at, " ", 1) = data AND quantidade > 0) as qtd
                 FROM movimentacao_estoque as me WHERE
                 substring_index(created_at, " ", 1) BETWEEN "' . $req->data_inicial . '" AND "' . $req->data_final . '"
                  order by data asc'
            );
            $movimentacao = MovimentacaoEstoque::whereBetween('created_at', array($req->data_inicial, $req->data_final))->where('quantidade', '>', 0)->get();
            $quantidade_movimentada = DB::select('SELECT SUM(quantidade) as qtd FROM movimentacao_estoque WHERE quantidade > 0 AND substring_index(created_at, " ", 1) BETWEEN "' .$req->data_inicial. '" AND "'.$req->data_final.'"');
            
            //Se for para selecionar o período com um estoque específico
        } else {
            $query_result = DB::select(
                'SELECT distinct substring_index(created_at, " ", 1) as data,
                (SELECT nome FROM produto WHERE id = (SELECT produto_id FROM estoque_has_produto WHERE estoque_id = ' . $req->estoque_id . ')) as nome,
                (SELECT SUM(quantidade*preco_custo) FROM movimentacao_estoque WHERE substring_index(created_at, " ", 1) = data AND estoque_id = ' . $req->estoque_id . ' AND quantidade > 0) as qtd
                 FROM movimentacao_estoque as me WHERE estoque_id = ' . $req->estoque_id . ' AND
                 substring_index(created_at, " ", 1) BETWEEN "' . $req->data_inicial . '" AND "' . $req->data_final . '"
                  order by data asc'
            );
            $movimentacao = MovimentacaoEstoque::whereBetween('created_at', array($req->data_inicial, $req->data_final))->where('quantidade', '>', 0)->where('estoque_id', $req->estoque_id)->get();
            $quantidade_movimentada = DB::select('SELECT SUM(quantidade) as qtd FROM movimentacao_estoque WHERE quantidade > 0 AND substring_index(created_at, " ", 1) BETWEEN "' .$req->data_inicial. '" AND "'.$req->data_final.'" AND estoque_id = '.$req->estoque_id);
        }

        //Transfere as datas e os valores para um array especifico que será utilizado como labels e dados do gráfico
        $labels = [];
        $dados = [];
        foreach ($query_result as $q) {
            array_push($dados, $q->qtd);
            array_push($labels, $q->data);
        }

        $total = 0;
        foreach($dados as $d){
            $total += $d;
        }

        $data = [
            'custo_medio' => round($total/$quantidade_movimentada[0]->qtd, 2),
            'custo_total' => $total,
            'quantidade_movimentada' => $quantidade_movimentada[0]->qtd,
            'estoque' => Estoque::all(),
            'estoque_selecionado' => $estoque_selecionado,
            'labels' => json_encode($labels),
            'dados' => json_encode($dados),
            'flag' => "1",
            'movimentacao' => $movimentacao,
            'data_inicial' => $req->data_inicial,
            'data_final' => $req->data_final
        ];

        return view('estoque::estoque.relatorios.custo', compact('data'));
    }

    public function relatorioMovimentacao()
    {
        $categorias = Categoria::all();

        return view('estoque::estoque.relatorios.movimentacao', compact('categorias'));
    }

    public function relatorioMovimentacaoBusca(Request $req){
        $estoque = Estoque::all();
        $ms = [];
        
        if ($req->estoque_id == -1){
            $ms  =  DB::select(
                    'SELECT distinc substring_index(created_at, " ", 1) as data,
                    (SELECT SUM(quantidade) FROM movimentacao_estoque WHERE substring_index(created_at, " ", 1) = data AND quantidade > 0) as qtdEntrada
                    (SELECT SUM(quantidade) FROM movimentacao_estoque WHERE substring_index(created_at, " ", 1) = data AND quantidade < 0) as qtdSaida
                        FROM movimentacao_estoque as me WHERE estoque_id = '.$req->estoque_id.' AND
                        substring_index(created_at, " ", 1) BETWEEN " '.$req->dataInicial.' "AND" '.$req->dataFinal.'"
                            order by data asc'
        );   
        }else{
            $ms  =  DB::select (
                    'SELECT distinc substring_index(created_at," ", 1) as data,
                     (SELECT nome FROM produto WHERE id = (SELECT produto_id FROM estoque_has_produto WHERE estoque_id = '.$req->estoque_id.')) as nome,
                     (SELECT SUM(quantidade) FROM movimentacao_estoque WHERE substring_index(created_at, " ",1) = data AND estoque_id = '.$req->estoque_id.' AND quantidade > 0) as qtdEntrada
                     (SELECT SUM(quantidade) FROM movimentacao_estoque WHERE substring_index(created_at, " ",1) = data AND estoque_id = '.$req->estoque_id.' AND quantidade > 0) as qtSaida
                        FROM movimentacao_estoque as me WHERE estoque_id = '.$req->estoque_id.' AND
                        substring_index(created_at, " ", 1) BETWEEN" '.$req->dataInicial.' "AND" '.$req->dataFinal.'"
                            order by data asc'
                
            );
        }

    }



    public function getSaidaProdutos(Request $request)
    {
        $produtos = DB::table('estoque')->where('deleted_at','<>',null)->get();
        return json_encode($produtos);

    }
}
