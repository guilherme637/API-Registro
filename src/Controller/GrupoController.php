<?php

namespace App\Controller;

use App\Repository\GrupoRepository;
use App\Helper\ResponseJsonFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GrupoController
{
    private GrupoRepository $grupoRepository;

    public function __construct(
        GrupoRepository $grupoRepository
    ) {
        $this->grupoRepository = $grupoRepository;
    }

    /**
     * @Route("/grupos", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $grupos = $this->grupoRepository->findAll();

        return ResponseJsonFactory::responseJson($grupos, JsonResponse::HTTP_OK);
    }
}