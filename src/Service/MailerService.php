<?php

namespace App\Service;

use App\Entity\Product;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Service\PriceChecker;

class MailerService {

    public function __construct(private MailerInterface $mailer, private PriceChecker $priceChecker) {}

    public function sendPriceAlert(Product $product, float $oldPrice, float $newPrice): void
    {
        $percentage = $this->priceChecker->getVariationPercentage($oldPrice, $newPrice);

        $email = (new Email())
        ->from('')
        ->to('')
        ->subject('baisse de prix')
        ->text(sprintf(
            "Le produit '%s' a baissé de %.2f € (%.1f%%) :\nAncien prix : %.2f €\nNouveau prix : %.2f €",
            $product->getNom(),
            $oldPrice - $newPrice,
            $percentage,
            $oldPrice,
            $newPrice
        ));

        $this->mailer->send($email);
    }
}