<?php

namespace App\Service;

use App\Entity\Financa;
use App\Repository\ContaRepository;

class ControlaGastoMensal
{
    public function verificaGastoMensal(ContaRepository $contaRepository, Financa $financa)
    {
        $feedData = $contaRepository->onlyDateFeedBack(); // pega a data do feedback
        $contaGrupo = $contaRepository->findAllGrupos(1); // pega as contas e os seus valores de acordo com o grupo

        $dataHojeFormat = $this->dateFormated();

        $search = array_search($dataHojeFormat, $feedData, true); // verifica se as datas confere

        if ($search === false) {
            return 'O mês ainda não foi encerrado.';
        }

        $resultado = [];

        foreach ($contaGrupo as $conta) {
            $resultado[] = $conta['valor'];
        }

        return array_sum($resultado);
    }

    private function dateFormated(): string
    {
        $data = new \DateTime(); // pega a data de hoje 2021-06-01

        return $data->format('d-m-Y'); // formata como string e no formata br
    }
}