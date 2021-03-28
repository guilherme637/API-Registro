<?php

namespace App\Controller;

use App\Repository\GrupoRepository;
use App\Helper\ResponseJsonFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GrupoController extends AbstractController
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