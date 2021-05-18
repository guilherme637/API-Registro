<?php

namespace App\Service;

use App\Entity\Conta;
use App\Repository\FinancaRepository;
use DateTime;
use Doctrine\Persistence\ObjectRepository;

class ContaFactory implements ContaFactoryInterface
{
    public function criarConta(string $dadosRequest, ObjectRepository $grupoRepository, ObjectRepository $financaRepository): Conta
    {
        $dadosJson = json_decode($dadosRequest);

        $grupo = $grupoRepository->find($dadosJson->tipo);
        $financa = $financaRepository->find($dadosJson->financa);

        $conta = new Conta();
        $conta
            ->setNome($dadosJson->nome)
            ->setValor($dadosJson->valor)
            ->setData($this->formatarData($dadosJson->data))
            ->setDataFeedBack($this->dataFeedback($dadosJson))
            ->setGrupo($grupo)
            ->setFinanca($financa)
        ;

        return $conta;
    }

    private function formatarData(string $data): \DateTime
    {
        $data = new DateTime($data);
        $data->format('d-m-Y');

        return $data;
    }

    private function dataFeedback($dadosJson)
    {
        $dataFeed = new DateTime($dadosJson->data);
        $proximaDataFeed = $dataFeed->modify('+1 month');

        return $proximaDataFeed->format('d-m-Y');;
    }
}