<?php

namespace App\Service\Mailer;

use App\Entity\Visitor;

interface UserMailerInterface
{
    public function newPendingProducer(Visitor $visitor): void;

    public function newProducerValidated(Visitor $visitor): void;
}
