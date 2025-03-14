<?php

namespace App\Http\Controllers;

use App\DTOs\PurchaseDTO;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Services\PurchaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    private $service;

    public function __construct(PurchaseService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        //ID del usuario autenticado
        $userId = auth()->user()->id;



        // Validar datos
        $validator = Validator::make($request->all(), [
            'products' => 'required|array',
            'products.*.amount' => 'integer|min:0',
            'payment' => 'required|in:tarjeta,contraentrega',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Preparar los datos para el DTO
        $products = [];
        foreach ($request->input('products') as $productId => $data) {
            if ($data['amount'] > 0) {
                $products[] = [
                    'id' => $productId,
                    'amount' => $data['amount'],
                ];
            }
        }

        if (empty($products)) {
            return redirect()->back()
                ->with('error', 'Debes seleccionar al menos un producto para comprar.')
                ->withInput();
        }

        $data = [
            'user_id' => $userId,
            'products' => $products,
            'payment' => $request->input('payment'),
        ];



        $dto = new PurchaseDTO($data);

        try {
            $this->service->create($dto);
            return redirect()->route('dashboard')->with('success', 'Compra realizada con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al realizar la compra: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        try {
            $details = $this->service->getDetails($id);
            return response()->json($details, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener el detalle de la compra: ' . $e->getMessage()], 500);
        }
    }

    public function showDetails($id)
    {
        $purchase = Purchase::find($id);
        $details = PurchaseDetail::where('purchase_id', $id)->get();

        return view('purchase-details', compact('purchase', 'details'));
    }
}
