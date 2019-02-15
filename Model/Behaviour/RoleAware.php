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

trait RoleAware
{
    protected $roles = [];

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles);
    }

    public function addRole(string $role)
    {
        array_push($this->roles, $role);
    }

    public function removeRole(string $role)
    {
        $this->roles = \array_filter($this->roles, function(string $r) use ($role) {
            return $r !== $role;
        });
    }

    public function replaceRoles(array $roles)
    {
        $this->roles = $roles;
    }
}