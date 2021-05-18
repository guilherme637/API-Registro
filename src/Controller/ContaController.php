<?php

namespace App\Controller;

use App\Helper\ExtratorRequestInterface;
use App\Repository\ContaRepository;
use App\Repository\FinancaRepository;
use App\Repository\GrupoRepository;
use App\Helper\ResponseJsonFactory;
use App\Service\ContaFactoryInterface;
use App\Service\UpdateContaServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContaController
{
    private ContaRepository $repository;
    private EntityManagerInterface $manager;
    private ContaFactoryInterface $contaFactory;
    private GrupoRepository $grupoRepository;
    private UpdateContaServiceInterface $updateContaService;
    private ExtratorRequestInterface $extrator;
    private FinancaRepository $financaRepository;

    public function __construct(
        EntityManagerInterface $manager,
        ContaRepository $repository,
        GrupoRepository $grupoRepository,
        ContaFactoryInterface $contaFactory,
        UpdateContaServiceInterface $updateContaService,
        ExtratorRequestInterface $extrator,
        FinancaRepository $financaRepository
    ) {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->contaFactory = $contaFactory;
        $this->grupoRepository = $grupoRepository;
        $this->updateContaService = $updateContaService;
        $this->extrator = $extrator;
        $this->financaRepository = $financaRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $ordena = $this->extrator->ordenar($request);
        $filtra = $this->extrator->filtrar($request);
        [$qtdItens, $page] = $this->extrator->itensPorPagina($request);

        $contas = $this->repository->findBy(
            $filtra,
            $ordena,
            $qtdItens,
            ($page - 1) * $qtdItens
        );

        $valorTotal = $this->repository->valueTotal();

        return ResponseJsonFactory::responseJson([$valorTotal, $contas], JsonResponse::HTTP_OK, $qtdItens, $page);
    }

    /**
     * @return JsonResponse
     * @var Request $request
     */
    public function store(Request $request): JsonResponse
    {
        $conta = $this->contaFactory->criarConta(
            $request->getContent(),
            $this->grupoRepository,
            $this->financaRepository
        );

        $this->repository->save($conta);

        return ResponseJsonFactory::responseJson('', Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $conta = $this->repository->find($id);

        return ResponseJsonFactory::responseJson($conta, JsonResponse::HTTP_ACCEPTED);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $novaConta = $this->contaFactory->criarConta(
            $request->getContent(),
            $this->grupoRepository,
            $this->financaRepository
        );

        $this->updateContaService->editarConta(
            $id,
            $novaConta,
            $this->repository,
            $this->grupoRepository
        );

        $this->repository->update();

        return ResponseJsonFactory::responseJson('', JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->manager->remove($this->repository->find($id));
        $this->manager->flush();

        return ResponseJsonFactory::responseJson('', JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @param int $grupoId
     * @return JsonResponse
     */
    public function findByGrupo(int $grupoId): JsonResponse
    {
        $grupoConta = $this->repository->findBy(
            [
                'grupo' => $grupoId
            ]
        );

        return ResponseJsonFactory::responseJson($grupoConta, JsonResponse::HTTP_ACCEPTED);
    }
}