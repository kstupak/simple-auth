<?php
/*
 * This file is part of "simple-auth".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleAuth\Service;


use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Toolbox\Infrastructure\Persistence\GenericRepository;

abstract class SecurityService implements SecurityServiceInterface
{
    /** @var GenericRepository */
    protected $repository;

    /** @var TokenStorageInterface */
    protected $tokenStorage;

    public function logout(UserInterface $user)
    {
        $user->removeToken();
        $this->repository->save($user);
    }

    public function getCurrentUser(): UserInterface
    {
        if (!$this->tokenStorage->getToken()) {
            throw new \BadMethodCallException('There is no token in token storage');
        }

        return $this->tokenStorage->getToken()->getUser();
    }
}