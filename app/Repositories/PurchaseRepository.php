<?php


namespace App\Repositories;

use App\Models\Purchase;

class PurchaseRepository
{
    public function create($data)
    {
        return Purchase::create($data);
    }
}