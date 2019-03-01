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
    const PASSWORD_RESET_REQUESTED = 'user.password_reset_request';
    const PASSWORD_RESET_CONFIRMED = 'user.password_reset_confirmed';

    private function __construct()
    {
        throw new \LogicException('This should not be instantiated');
    }
}