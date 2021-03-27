<?php

namespace App\Controller;

use App\Repository\ContaRepository;
use App\Repository\GrupoRepository;
use App\Service\ContaFactory;
use App\Service\ExtratorRequest;
use App\Service\ResponseJsonFactory;
use App\Service\UpdateContaService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ContaController extends AbstractController
{
    private ContaRepository $repository;
    private EntityManagerInterface $manager;
    private ContaFactory $contaFactory;
    private GrupoRepository $grupoRepository;
    private UpdateContaService $updateContaService;
    private ExtratorRequest $extrator;

    public function __construct(
        EntityManagerInterface $manager,
        ContaRepository $repository,
        GrupoRepository $grupoRepository,
        ContaFactory $contaFactory,
        UpdateContaService $updateContaService,
        ExtratorRequest $extrator
    ) {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->contaFactory = $contaFactory;
        $this->grupoRepository = $grupoRepository;
        $this->updateContaService = $updateContaService;
        $this->extrator = $extrator;
    }

    /**
     * @Route ("/contas", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $ordena = $this->extrator->ordernar($request);
        $filtra = $this->extrator->filtrar($request);
        [$qtdItens, $page] = $this->extrator->itensPorPagina($request);

        $contas = $this->repository->findBy(
            $filtra,
            $ordena,
            $qtdItens,
            ($page - 1) * $qtdItens
        );

        return ResponseJsonFactory::responseJson($contas, JsonResponse::HTTP_OK, $qtdItens, $page);
    }

    /**
     * @Route ("/contas", methods={"POST"})
     * @return JsonResponse
     * @var Request $request
     */
    public function store(Request $request): JsonResponse
    {
        $conta = $this->contaFactory->criarConta(
            $request->getContent(),
            $this->grupoRepository
        );

        $this->repository->save($conta);

        return ResponseJsonFactory::responseJson('', Response::HTTP_CREATED);
    }

    /**
     * @Route ("conta/{id}", methods={"GET"})
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $conta = $this->repository->find($id);

        return ResponseJsonFactory::responseJson($conta, JsonResponse::HTTP_ACCEPTED);
    }

    /**
     * @Route ("/conta/{id}/update", methods={"PUT"})
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function update(int $id, Request $request): Response
    {
        $novaConta = $this->contaFactory->criarConta(
            $request->getContent(),
            $this->grupoRepository
        );

        $this->updateContaService->editarConta(
            $id,
            $novaConta,
            $this->repository,
            $this->grupoRepository
        );

        $this->repository->update();

        return ResponseJsonFactory::responseJson('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route ("/conta/{id}/delete", methods={"DELETE"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id): Response
    {
        $this->manager->remove($this->repository->find($id));
        $this->manager->flush();

        return ResponseJsonFactory::responseJson('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route ("/tipo/conta/{grupoId}", methods={"GET"})
     * @param int $grupoId
     * @return JsonResponse
     */
    public function findByGrupo(int $grupoId)
    {
        $grupoConta = $this->repository->findBy(
            [
                'grupo' => $grupoId
            ]
        );

        return ResponseJsonFactory::responseJson($grupoConta, JsonResponse::HTTP_ACCEPTED);
    }
}