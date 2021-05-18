<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Request;

interface ExtratorRequestInterface
{
    public function filtrar(Request $request): ?array;
    public function ordenar(Request $request): ?array;
    public function itensPorPagina(Request $request): ?array;
}