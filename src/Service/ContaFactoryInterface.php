<?php

namespace App\Service;

use App\Entity\Conta;
use Doctrine\Persistence\ObjectRepository;

interface ContaFactoryInterface
{
    public function criarConta(
        string $dadosRequest,
        ObjectRepository $grupoRepository,
        ObjectRepository $financaRepository
    ): Conta;
}