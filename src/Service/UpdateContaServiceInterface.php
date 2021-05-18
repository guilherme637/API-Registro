<?php

namespace App\Service;

use App\Entity\Conta;
use App\Repository\ContaRepository;
use App\Repository\GrupoRepository;

/**
 * Interface UpdateContaServiceInterface
 * @package App\Service
 */
interface UpdateContaServiceInterface
{
    public function editarConta(
        int $id,
        Conta $novaConta,
        ContaRepository $repository,
        GrupoRepository $grupoRepository
    ): object;
}