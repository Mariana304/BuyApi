<?php 
namespace App\DTOs;

class PurchaseDTO
{
    public $user_id;
    public $products;
    public $payment;

    public function __construct($data)
    {

        $this->user_id = $data['user_id'];
        $this->products = $data['products'];
        $this->payment = $data['payment'] ?? null; // Permitir null para el método de pago
    }
}