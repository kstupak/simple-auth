<?php
/*
 * This file is part of "simple-auth".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleAuth\Model;

use SimpleAuth\Model\Behaviour\AccessTokenAware;
use SimpleAuth\Model\Behaviour\HasPasswordResetToken;
use SimpleAuth\Model\Behaviour\RoleAware;
use SimpleAuth\Model\Behaviour\UserInterfaceCompliant;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    const ACCESS_TOKEN_LENGTH = 16;
    const RESET_TOKEN_LENGTH  = 16;

    use UserInterfaceCompliant,
        RoleAware,
        AccessTokenAware,
        HasPasswordResetToken;

    /** @var string */
    protected $email;

    /** @var string */
    protected $name;

    /** @var bool */
    protected $active;

    /** @var string */
    protected $password;

    public function __construct(
        string $name,
        string $email,
        string $password
    ){
        $this->name     = $name;
        $this->email    = $email;
        $this->password = $password;
        $this->active   = true;

        $this->resetToken(self::RESET_TOKEN_LENGTH);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function checkPassword(string $password, callable $checker = null): bool
    {
        if ($checker) {
            return $checker($password, $this->password);
        }

        return password_verify($password, $this->password);
    }
}