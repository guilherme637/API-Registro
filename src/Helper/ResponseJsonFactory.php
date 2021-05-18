<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseJsonFactory
{
    /**
     * @param string|array $response
     * @param int $status
     * @param int|null $itens
     * @param int|null $pagina
     * @return JsonResponse
     */
    public static function responseJson(
        $response,
        int $status = 200,
        ?int $itens = null,
        ?int $pagina = null
    ): JsonResponse {

        $content = [
            'status' => $status,
            'itensPorPagina' => $itens,
            'paginaAtual' => $pagina,
            'results' => $response
        ];

        if (is_array($response) && count($response) === 2) {
            $content = [
                'status' => $status,
                'itensPorPagina' => $itens,
                'paginaAtual' => $pagina,
                'valorTotalDasContas' => $response[0],
                'results' => $response[1]
            ];

            return new JsonResponse($content, $status);
        }

        if (is_null($itens) || is_null($pagina)) {
            unset($content['itensPorPagina']);
            unset($content['paginaAtual']);
        }

        if (empty($content['results'])) {
            unset($content['results']);
        }

        return new JsonResponse($content, $status);
    }
}