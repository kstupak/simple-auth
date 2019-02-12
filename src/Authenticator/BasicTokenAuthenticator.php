<?php
/*
 * This file is part of "simple-auth".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleAuth\Authenticator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

abstract class BasicTokenAuthenticator extends AbstractGuardAuthenticator
{
    const HEADER_KEY = 'Authorization';

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
    }

    public function getCredentials(Request $request)
    {
        return [
            'token' => $request->headers->get(self::HEADER_KEY),
        ];
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse('Forbidden', Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function supportsRememberMe()
    {
        return false;
    }
}