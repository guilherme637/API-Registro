<?php

namespace App\Service;

use App\Entity\Financa;

class FinanceFactory implements FinanceFactoryInterface
{
    public function criaFinanca(string $request): Financa
    {
        $jsonData = json_decode($request);

        $finance = new Financa();
        $finance->setSaldo($jsonData->saldo);
        $finance->setData(new \DateTime($jsonData->data));

        return $finance;
    }
}