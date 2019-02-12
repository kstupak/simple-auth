<?php
/*
 * This file is part of "simple-auth".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleAuth;

use Assert\Assertion;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

abstract class UserProvider implements UserProviderInterface
{
    /** @var EntityRepository */
    protected $repository;

    public function loadUserByUsername($username): UserInterface
    {
        $user = $this->repository->findOneBy(['email' => $username]);
        Assertion::notEmpty($user);

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function findByAccessToken(string $token): UserInterface
    {
        $user = $this->repository->findOneBy(['accessToken.token' => $token]);
        Assertion::notEmpty($user);

        return $user;
    }
}