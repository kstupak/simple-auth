<?php
/*
 * This file is part of "simple-auth".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleAuth\Controller;

use SimpleAuth\Service\Authenticator\UsernamePasswordAuthenticator;
use SimpleAuth\Service\SecurityServiceInterface;
use SimpleAuth\Service\UserServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Toolbox\Controller\Traits\CanRespondWithJson;

/**
 * @Route("", name="security_")
 */
class SecurityController
{
    use CanRespondWithJson;

    /** @var SecurityServiceInterface */
    private $securityService;
    /** @var UserServiceInterface */
    private $userService;
    /** @var SerializerInterface */
    private $serializer;

    public function __construct(
        SecurityServiceInterface $securityService,
        UserServiceInterface $userService,
        SerializerInterface $serializer
    ){
        $this->securityService = $securityService;
        $this->userService     = $userService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request): Response
    {
        $email    = $request->get('email');
        $password = $request->get('password');

        try {
            $token = $this->securityService->login($email, $password);
            $response = new JsonResponse($token, Response::HTTP_OK);
        } catch (\Exception $e) {
            $response = new JsonResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        return $response;
    }

    /**
     * @Route("/logout", name="logout", methods={"GET"})
     */
    public function logout(Request $request): Response
    {
        $this->securityService->logout($this->securityService->getCurrentUser());
        return $this->respond('OK');
    }

    /**
     * @Route("/reset", name="reset", methods={"POST"})
     */
    public function resetRequest(Request $request): Response
    {
        if (!$request->request->has('user')) {
            throw new \InvalidArgumentException('User ID missing');
        }

        $this->userService->requestUserPasswordReset($request->get('user'));
        return $this->respond('OK');
    }

    /**
     * @Route("/reset/{token}", name="reset_confirm", methods={"POST"})
     */
    public function resetConfirm(Request $request, string $token): Response
    {
        $this->userService->confirmUserPasswordReset($token, $request->get('password'));
        return $this->respond('OK');
    }

    /**
     * @Route("/current", name="current_user", methods={"GET"})
     */
    public function getCurrentUser(): Response
    {
        return $this->respond($this->securityService->getCurrentUser());
    }
}