<?php
/*
 * This file is part of "simple-auth".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleAuth\Service\Authenticator;

use SimpleAuth\Event\UserEvent;
use SimpleAuth\Event\UserEvents;
use SimpleAuth\Model\User;
use SimpleAuth\UserProvider;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

final class UsernamePasswordAuthenticator
{
    /** @var UserProvider */
    private $provider;
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(
        UserProvider $provider,
        EventDispatcherInterface $eventDispatcher
    ){
        $this->provider        = $provider;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function checkCredentials($credentials, User $user): bool
    {
        return $user->checkPassword($credentials);
    }

    public function getUser(string $username): User
    {
        return $this->provider->loadUserByUsername($username);
    }

    public function login(string $username, string $password): string
    {
        $user = $this->getUser($username);

        if (!$this->checkCredentials($password, $user)) {
            throw new AuthenticationException('Forbidden');
        }

        $this->eventDispatcher->dispatch(UserEvents::LOGIN, new UserEvent($user));

        if (!$user->getAccessToken()) {
            throw new AuthenticationException('Forbidden');
        }

        return $user->getAccessToken()->getToken();
    }
}