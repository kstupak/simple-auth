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

trait PermissionsAware
{
    /** @var int */
    private $permissions;

    public function getPermissions(): int
    {
        return $this->permissions;
    }


}