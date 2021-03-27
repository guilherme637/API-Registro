<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class ExtratorRequest
{
    private function verificarDadosRequest(Request $request)
    {
        $queryString = $request->query->all();
        $ordenaDados = array_key_exists('sort', $queryString)
            ? $queryString['sort'] :
            null;
        unset($queryString['sort']);

        $qtdItens = array_key_exists('itens', $queryString)
            ? $queryString['itens']
            : 10;
        unset($queryString['itens']);

        $pagina = array_key_exists('page', $queryString)
            ? $queryString['page']
            : 1;
        unset($queryString['page']);

        return [$queryString, $ordenaDados, $qtdItens, $pagina];
    }

    public function filtrar(Request $request)
    {
        [$filtraDados] = $this->verificarDadosRequest($request);

        return $filtraDados;
    }

    public function ordernar(Request $request)
    {
        [ , $ordenacao] = $this->verificarDadosRequest($request);

        return $ordenacao;
    }

    public function itensPorPagina(Request $request)
    {
        [ , , $qtdItens, $pagina] = $this->verificarDadosRequest($request);

        return [$qtdItens, $pagina];
    }
}