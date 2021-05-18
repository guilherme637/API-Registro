<?php

namespace App\Service;

use App\Entity\Conta;
use App\Repository\ContaRepository;
use App\Repository\GrupoRepository;

class UpdateContaService implements UpdateContaServiceInterface
{
    public function editarConta(
        int $id,
        Conta $novaConta,
        ContaRepository $repository,
        GrupoRepository $grupoRepository
    ): object {
        $contaExistente = $repository->find($id);

        $contaExistente
            ->setNome($novaConta->getNome())
            ->setValor($novaConta->getValor())
            ->setData($novaConta->getData())
            ->setGrupo($novaConta->getGrupo());

        return $contaExistente;
    }
}