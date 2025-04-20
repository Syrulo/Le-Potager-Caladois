<?php 

namespace App\Service;

use App\Repository\ProductRepository;

class GetProductPrice
{
    public function getProductPrice(ProductRepository $productRepository, $id)
    {
        $price = $productRepository->findOneBy(['id' => $id])->getPrice();
    }
}