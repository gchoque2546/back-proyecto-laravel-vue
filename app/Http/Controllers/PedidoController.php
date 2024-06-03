<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::with(['cliente', 'user', 'productos'])->paginate(10);
        return response()->json($pedidos,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validar
        $request->validate([
            "cliente_id" => "required",
            "productos" => "required",
        ]);

        DB::beginTransaction();
            try {
            // Crear el Pedido
            $pedido = new Pedido();
            $pedido->fecha = date("Y-m-d H:i:s");
            $pedido->observacion = "Sin Observaciones"; 
            $pedido->cliente_id = $request->cliente_id;
            $pedido->user_id = Auth::user()->id;
            $pedido->save();

            // Asignar los productos al pedido
            $productos = $request->productos;
            foreach ($productos as $prod) {
                $producto_id = $prod["producto_id"];
                $cantidad = $prod["cantidad"];
                $pedido->productos()->attach($producto_id, ["cantidad" => $cantidad]);
            }
            //1:11:46 
            DB::commit();
            return response()->json(["message" => "Pedido Registrado"],201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["message" => "Error al Registrar el Pedido", "error" => $e->getMessage()],422);
        }
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
