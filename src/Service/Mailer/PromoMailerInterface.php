<?php

namespace App\Service\Mailer;

use App\Entity\Product;

interface PromoMailerInterface 
{
    public function sendPriceAlert(Product $product, float $oldPrice, float $newPrice): void;
}