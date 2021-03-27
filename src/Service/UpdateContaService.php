<?php

namespace App\Service;

use App\Entity\Conta;
use App\Repository\GrupoRepository;
use Doctrine\Persistence\ObjectRepository;

class UpdateContaService
{
    public function editarConta(
        int $id,
        Conta $novaConta,
        ObjectRepository $repository,
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