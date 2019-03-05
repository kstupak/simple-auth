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


use Symfony\Component\Security\Core\User\UserInterface;

interface SecurityServiceInterface
{
    public function login(string $username, string $password): string;
    public function logout(UserInterface $user);

    public function getCurrentUser(): UserInterface;
}