<?php

namespace App\Controller;

use App\Entity\Financa;
use App\Helper\ResponseJsonFactory;
use App\Repository\ContaRepository;
use App\Repository\FinancaRepository;
use App\Service\ControlaGastoMensal;
use App\Service\FinanceFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FinancaController
{
    private FinancaRepository $financaRepository;
    private EntityManagerInterface $manager;
    private ContaRepository $contaRepository;
    private ControlaGastoMensal $controlaGastoMensal;
    private FinanceFactoryInterface $financeFactory;

    public function __construct(
        EntityManagerInterface $manager,
        FinancaRepository $financaRepository,
        ContaRepository $contaRepository,
        ControlaGastoMensal $controlaGastoMensal,
        FinanceFactoryInterface $financeFactory
    ) {
        $this->financaRepository = $financaRepository;
        $this->manager = $manager;
        $this->contaRepository = $contaRepository;
        $this->controlaGastoMensal = $controlaGastoMensal;
        $this->financeFactory = $financeFactory;
    }

    /**
     * @Route("/", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $financas = $this->financaRepository->billsByFinance();

        return ResponseJsonFactory::responseJson($financas, JsonResponse::HTTP_OK);
    }

    /**
     * @Route ("/", methods={"POST"})
     */
    public function store(Request $request): JsonResponse
    {
        $finance = $this->financeFactory->criaFinanca($request->getContent());
        
        $this->manager->persist($finance);
        $this->manager->flush();

        return ResponseJsonFactory::responseJson('', JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route ("/servicos", methods={"GET"})
     */
    public function controlaGastoMensal(): JsonResponse
    {
        $resposta = $this->controlaGastoMensal->verificaGastoMensal($this->contaRepository, new Financa());

        if (is_string($resposta)) {
            return ResponseJsonFactory::responseJson($resposta, JsonResponse::HTTP_BAD_REQUEST);
        }

        return ResponseJsonFactory::responseJson($resposta);
    }
}