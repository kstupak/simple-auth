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

    /** @var \DateTimeImmutable */
    private $accessTokenExpiresAt;

    public function getAccessToken(): ?AccessToken
    {
        if (!$this->accessToken || !$this->accessTokenExpiresAt) { return null; }

        return AccessToken::restore($this->accessToken, $this->accessTokenExpiresAt);
    }

    public function createToken(?int $tokenLength = null)
    {
        $token = AccessToken::create($tokenLength);
        $this->accessToken          = $token->getToken();
        $this->accessTokenExpiresAt = $token->getExpiresAt();
    }

    public function removeToken()
    {
        $this->accessToken          = null;
        $this->accessTokenExpiresAt = null;
    }
}