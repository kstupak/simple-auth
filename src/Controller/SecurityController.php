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

use SimpleAuth\Authenticator\UsernamePasswordAuthenticator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("", name="security_")
 */
final class SecurityController
{
    /** @var UsernamePasswordAuthenticator */
    private $authenticator;

    public function __construct(
        UsernamePasswordAuthenticator $authenticator
    ){
        $this->authenticator = $authenticator;
    }

    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request): Response
    {
        $email    = $request->get('email');
        $password = $request->get('password');

        try {
            $token = $this->authenticator->login($email, $password);
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
        throw new \RuntimeException("NYI");
    }

    /**
     * @Route("/reset", name="reset", methods={"POST"})
     */
    public function resetRequest(Request $request): Response
    {
        throw new \RuntimeException("NYI");
    }

    /**
     * @Route("/reset/{token}", name="reset_confirm", methods={"POST"})
     */
    public function resetConfirm(Request $request, string $token): Response
    {
        throw new \RuntimeException("NYI");
    }
}