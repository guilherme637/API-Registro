<?php

namespace App\Service;

use App\Entity\Financa;

interface FinanceFactoryInterface
{
    public function criaFinanca(string $request): Financa;
}