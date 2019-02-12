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


use SimpleAuth\Model\AccessToken;

trait AccessTokenAware
{
    /** @var AccessToken */
    private $accessToken;

    public function getAccessToken(): ?AccessToken
    {
        return $this->accessToken;
    }

    public function createToken(int $tokenLength = null)
    {
        $this->accessToken = AccessToken::create($tokenLength);
    }

    public function removeToken()
    {
        $this->accessToken = null;
    }
}