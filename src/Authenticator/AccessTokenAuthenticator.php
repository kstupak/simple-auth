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

use SimpleAuth\Model\AccessToken;
use SimpleAuth\Model\User;
use SimpleAuth\UserProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class AccessTokenAuthenticator extends BasicTokenAuthenticator
{
    /** @var UserProvider */
    private $provider;

    public function __construct(UserProvider $provider)
    {
        $this->provider = $provider;
    }

    public function supports(Request $request)
    {
        return $request->headers->has(self::HEADER_KEY)
            && (strlen($request->headers->get(self::HEADER_KEY)) === AccessToken::TOKEN_LENGTH);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            return $this->provider->findByAccessToken($credentials['token']);
        } catch (\Exception $e) {
        }

        return null;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        /** @var User $user */
        return !$user->getToken()->isExpired();
    }

}