<?php

namespace App\Controller;

use App\Helper\ExtratorRequest;
use App\Repository\ContaRepository;
use App\Repository\GrupoRepository;
use App\Service\ContaFactory;
use App\Helper\ResponseJsonFactory;
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
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
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
            $this->grupoRepository
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