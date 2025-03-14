<?php
namespace App\DTOs;

class ProductDTO
{
    public $name;
    public $price;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->price = $data['price'];
    }
}