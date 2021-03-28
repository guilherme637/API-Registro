<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Request;

class ExtratorRequest
{
    private VerificaQueryString $verifica;

    public function __construct()
    {
        $this->verifica = new VerificaQueryString();
    }

    public function filtrar(Request $request)
    {
        [$filtraDados] = $this->verifica->verificarDadosRequest($request);

        return $filtraDados;
    }

    public function ordernar(Request $request)
    {
        [ , $ordenacao] = $this->verifica->verificarDadosRequest($request);

        return $ordenacao;
    }

    public function itensPorPagina(Request $request)
    {
        [ , , $qtdItens, $pagina] = $this->verifica->verificarDadosRequest($request);

        return [$qtdItens, $pagina];
    }
}