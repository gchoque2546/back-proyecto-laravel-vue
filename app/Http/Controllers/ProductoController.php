<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // http://127.0.0.1:8000/api/producto?page=5&q=tec
        $buscar = isset($request->q)?$request->q : '';

        if($buscar){
            $productos = Producto::orderBy('id', 'desc')
                                    ->where('nombre', 'like', '%'.$buscar.'%')
                                    ->with("categoria")
                                    ->paginate(10);
        }else{
            $productos = Producto::orderBy('id', 'desc')->with("categoria")->paginate(10);
        }
        return response()->json($productos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validar
        $request->validate([
            "nombre" => "required",
            "categoria_id" => "required"
        ]);
        //guardar
        $prod = new Producto();
        $prod->nombre = $request->nombre;
        $prod->precio = $request->precio;
        $prod->stock = $request->stock;
        $prod->categoria_id = $request->categoria_id;
        $prod->descripcion = $request->descripcion;
        $prod->save();
        //responder
        return response()->json(["message" => "Producto Registrado"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
