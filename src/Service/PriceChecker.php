<?php

namespace App\Service;

class PriceChecker
{
    public function calculatePriceVariation(float $oldPrice, float $newPrice, float $threshold = 30.0): bool
    {
        if ($oldPrice <= 0) {
            return false;
        }

        if ($newPrice >= $oldPrice) {
            return false;
        }

        $variation = (($oldPrice - $newPrice) / $oldPrice) * 100;

        return $variation >= $threshold;
    }

    public function getVariationPercentage(float $oldPrice, float $newPrice): float
    {
        $variation = (($oldPrice - $newPrice) / $oldPrice) * 100;

        return $variation;
    }
}
