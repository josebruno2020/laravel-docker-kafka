<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilhoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, string $id_animal)
    {
        try {
            $id = $request->get('id');
            $nome = $request->get('nome');
            $data = DB::collection('animals')->where('_id', $id_animal)->push('filhotes', ['id' => $id, 'nome' => $nome]);
            return response()->json($data);
        }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id_animal, int $id)
    {   
        try {
            $collection = DB::collection('animals')
                ->where('_id', $id_animal)
                ->pull('filhotes', [
                    'id' => $id
                ]);

            return response()->json($collection);
        } catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
