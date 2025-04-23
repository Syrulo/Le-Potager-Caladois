<?php

namespace App\Service\Mailer;

use App\Entity\Visitor;

interface UserMailerInterface 
{
    public function newPendingProducer(Visitor $visitor) : void;
}