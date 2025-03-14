<?php

namespace App\Http\Controllers;


use App\DTOs\ProductDTO;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        // Validación de datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // Enviar errores a la vista
                ->withInput();
        }

        try {
            $dto = new ProductDTO($request->all());
            $this->service->create($dto);
            return redirect()->route('dashboard')->with('success', 'Producto creado con éxito');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear el producto: ' . $e->getMessage())
                ->withInput();
        }
    }
}
