<?php
/*
 * This file is part of "simple-auth".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleAuth\Event;

class UserEvents
{
    const LOGIN  = 'user.login';
    const LOGOUT = 'user.logout';

    private function __construct()
    {
        throw new \LogicException('This should not be instantiated');
    }
}