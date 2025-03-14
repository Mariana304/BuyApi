<?php

namespace App\Services;

use App\Models\Purchase; // Importa el modelo Purchase
use App\Models\Product; // Importa el modelo Product
use App\DTOs\PurchaseDTO;
use App\Repositories\PurchaseRepository;
use App\Repositories\PurchaseDetailRepository;
use Illuminate\Support\Facades\DB; // Importa la clase DB para las transacciones

class PurchaseService
{
    private $purchaseRepository;
    private $purchaseDetailRepository;

    public function __construct(PurchaseRepository $purchaseRepository, PurchaseDetailRepository $purchaseDetailRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
        $this->purchaseDetailRepository = $purchaseDetailRepository;
    }

    public function create(PurchaseDTO $dto)
    {
        return DB::transaction(function () use ($dto) {
            $total = 0;

            // Calcular total 
            foreach ($dto->products as $productData) {
                $product = Product::find($productData['id']);
                if (!$product) {
                    throw new \Exception("Producto con ID {$productData['id']} no encontrado.");
                }
                $total += $product->price * $productData['amount'];
            }

          
            $purchase = $this->purchaseRepository->create([
                'user_id' => $dto->user_id,
                'total' => $total,
                'payment' => $dto->payment,
            ]);

            // detalles de la compra
            foreach ($dto->products as $productData) {
                $product = Product::find($productData['id']);
                $this->purchaseDetailRepository->create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product->id,
                    'quantity' => $productData['amount'],
                ]);
            }

            return $purchase;
        });
    }

    public function getDetails($id)
    {
        $purchase = Purchase::find($id);

        if (!$purchase) {
            throw new \Exception("Compra con ID {$id} no encontrada.");
        }

        $user = $purchase->user;
        $products = [];

        foreach ($purchase->details as $detail) {
            $product = Product::find($detail->product_id);
            $products[] = [
                'id' => $product->id,
                'name' => $product->name,
                'value' => $product->price,
                'amount' => $detail->quantity,
                'total' => $product->price * $detail->quantity,
            ];
        }

        $total = $purchase->total;
        $payment = $purchase->payment;
        $createdAt = $purchase->created_at;
        $updatedAt = $purchase->updated_at;

        return [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
            ],
            'products' => $products,
            'total' => $total,
            'payment' => $payment,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
