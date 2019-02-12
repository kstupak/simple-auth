<?php
/*
 * This file is part of "simple-auth".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleAuth\Model\Behaviour;


trait UserInterfaceCompliant
{
    public function getRoles()
    {
        return $this->roles ?? [];
    }

    public function getUsername()
    {
        return $this->email ?? $this->username;
    }

    public function eraseCredentials() {}
    public function getSalt() {}
}