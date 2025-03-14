<?php
namespace App\Repositories;

use App\Models\PurchaseDetail;

class PurchaseDetailRepository
{
    public function create($data)
    {
        return PurchaseDetail::create($data);
    }
}
