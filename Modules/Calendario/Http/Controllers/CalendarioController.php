<?php

namespace Modules\Calendario\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CalendarioController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('calendario::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('calendario::create');
    }

    public function eventos()
    {
        $calendario = [
            [
                'id' => 1,
                'title' => 'Curso',
                'start' => '2019-06-20 08:00',
                'end' => '2019-06-22 19:00',
                'backgroundColor' => 'red',
                'borderColor' => 'red',
                'classNames' => 'calendario01'
            ],
            [
                'id' => 2,
                'title' => 'Porra',
                'start' => '2019-06-23',
                'backgroundColor' => 'red',
                'borderColor' => 'red',
                'classNames' => 'calendario01'
            ],
            [
                'id' => 3,
                'title' => 'Porra',
                'start' => '2019-06-15',
                'end' => '2019-06-16',
                'backgroundColor' => 'blue',
                'borderColor' => 'blue',
                'classNames' => 'calendario02'
            ],
            [
                'id' => 4,
                'title' => 'Porra',
                'start' => '2019-06-10',
                'end' => '2019-06-11',
                'backgroundColor' => 'blue',
                'borderColor' => 'blue',
                'classNames' => 'calendario02'
            ]
        ];

        return json_encode($calendario);
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
        return view('calendario::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('calendario::edit');
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
