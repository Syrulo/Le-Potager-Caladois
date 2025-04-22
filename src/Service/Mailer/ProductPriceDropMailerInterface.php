<?php
namespace App\Service\Mailer;

use App\Entity\Product;

interface ProductPriceDropMailerInterface 
{
    public function sendPriceAlert(Product $product, float $oldPrice, float $newPrice): void;
}