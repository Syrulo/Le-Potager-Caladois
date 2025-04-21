<?php 

namespace App\Service;

class PriceChecker
{
    public function calculatePriceVariation(float $oldPrice, float $newPrice, float $threshold = 30.0): bool
    {
        if($oldPrice == 0) {
            return false;
        }

        $variation = abs(($newPrice - $oldPrice) / $oldPrice) * 100;

        return $variation >= $threshold;
    }
}