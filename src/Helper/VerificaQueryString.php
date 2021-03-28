<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Request;

class VerificaQueryString
{
    public function verificarDadosRequest(Request $request)
    {
        $queryString = $request->query->all();

        $ordenaDados = $this->verificaSeOrdena($queryString);
        unset($queryString['sort']);

        $qtdItens = $this->verificaQtdItens($queryString);
        unset($queryString['itens']);

        $pagina = $this->verificaSeTemPagina($queryString);
        unset($queryString['page']);

        return [$queryString, $ordenaDados, $qtdItens, $pagina];
    }

    private function verificaSeOrdena($queryString)
    {
        $ordenaDados = array_key_exists('sort', $queryString)
            ? $queryString['sort'] :
            null;

        return $ordenaDados;
    }

    private function verificaQtdItens($queryString)
    {
        $qtdItens = array_key_exists('itens', $queryString)
            ? $queryString['itens']
            : 10;

        return $qtdItens;
    }

    private function verificaSeTemPagina($queryString)
    {
        $pagina = array_key_exists('page', $queryString)
            ? $queryString['page']
            : 1;

        return $pagina;
    }
}