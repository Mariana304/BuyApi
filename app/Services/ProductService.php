<?php
namespace App\Services;

use App\DTOs\ProductDTO;
use App\Repositories\ProductRepository;

class ProductService
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(ProductDTO $dto)
    {
        return $this->repository->create([
            'name' => $dto->name,
            'price' => $dto->price,
        ]);
    }
}