<?php

namespace App\Service;

use App\Entity\Conta;
use DateTime;
use Doctrine\Persistence\ObjectRepository;

class ContaFactory
{
    public function criarConta(string $dadosRequest, ObjectRepository $grupoRepository): Conta
    {
        $dadosJson = json_decode($dadosRequest);

        $grupo = $grupoRepository->find($dadosJson->tipo);

        $conta = new Conta();
        $conta
            ->setNome($dadosJson->nome)
            ->setValor($dadosJson->valor)
            ->setData($this->formatarData($dadosJson->data))
            ->setGrupo($grupo);

        return $conta;
    }

    private function formatarData(string $data): \DateTime
    {
        $data = new DateTime($data);
        $data->format('d-m-Y');

        return $data;
    }
}