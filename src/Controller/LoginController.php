<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\ResponseJsonFactory;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginController extends AbstractController
{
    private UserRepository $repository;
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserRepository $repository, UserPasswordEncoderInterface $encoder)
    {
        $this->repository = $repository;
        $this->encoder = $encoder;
    }

    /**
     * @Route("/login", methods={"POST"}, name="login")
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $dadosJson = json_decode($request->getContent());

        if (is_null($dadosJson->username) || is_null($dadosJson->senha)) {
            return ResponseJsonFactory::responseJson(
                ['message' => 'Envie um username e uma senha'],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $user = $this->repository->findOneBy(
            ['username' => $dadosJson->username]
        );

        if (!$this->encoder->isPasswordValid($user, $dadosJson->senha)) {
            return new JsonResponse(
                [
                    'error' => 'Usuário e senha inválidos'
                ], JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $jwt = JWT::encode(['username' => $user->getUsername()], '18491@//134/@usSAj', 'HS256');

        return new JsonResponse(
            [
                'access_token' => $jwt
            ]
        );
    }
}
