<?php

namespace Modules\Webservices\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Webservices\Entities\{WebService};

class WebservicesController extends Controller
{
    protected $moduleInfo;
    protected $menu;

    public function  __construct(){
        $this->moduleInfo = [
            'icon' => 'store',
            'name' => 'WEBSERVICES',
        ];
        $this->menu = [
            ['icon' => 'shop', 'tool' => 'Itens', 'route' => '/compra/itemCompra/'],
            ['icon' => 'library_books', 'tool' => 'Pedidos', 'route' => '/compra/pedido/'],
            ['icon' => 'local_shipping', 'tool' => 'Fornecedores', 'route' => '/compra/fornecedor/'],
            ['icon' => 'search', 'tool' => 'Busca', 'route' => '#'],
            ['icon' => 'location_searching', 'tool' => 'Localizar objeto', 'route'=>'/webservices/webServices'],
        ];
    }
    public function index()
    {
        
        $moduleInfo = $this->moduleInfo;
        $menu = $this->menu;

        $data = [
           'web_service'=>WebService::all(),
           'title' => 'Lista de Objetos Recentemente Pesquisado',
           'icon' => 'store',
           'name' => 'Webservices',
        ]; 
            
        return view('webservices::webServices.index', compact('data','moduleInfo','menu'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('webservices::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('webservices::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('webservices::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
