<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Request;

class ExtratorRequest implements ExtratorRequestInterface
{
    private VerificaQueryString $verifica;

    public function __construct()
    {
        $this->verifica = new VerificaQueryString();
    }

    public function filtrar(Request $request): ?array
    {
        [$filtraDados] = $this->verifica->verificarDadosRequest($request);

        return $filtraDados;
    }

    public function ordenar(Request $request): ?array
    {
        [ , $ordenacao] = $this->verifica->verificarDadosRequest($request);

        return $ordenacao;
    }

    public function itensPorPagina(Request $request): ?array
    {
        [ , , $qtdItens, $pagina] = $this->verifica->verificarDadosRequest($request);

        return [$qtdItens, $pagina];
    }
}