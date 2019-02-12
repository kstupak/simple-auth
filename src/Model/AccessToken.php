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


use Toolbox\Utility\TokenGenerator;

final class AccessToken
{
    const TOKEN_LENGTH = 16;
    const TOKEN_TTL    = 604800;

    /** @var string */
    private $token;

    /** @var \DateTimeImmutable */
    private $expiresAt;

    private function __construct(string $token, \DateTimeImmutable $expiresAt)
    {
        $this->token     = $token;
        $this->expiresAt = $expiresAt;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getExpiresAt(): \DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function isExpired(): bool
    {
        return (new \DateTimeImmutable())->getTimestamp() >= $this->expiresAt->getTimestamp();
    }

    public static function create(int $length = self::TOKEN_LENGTH): self
    {
        $token = (new TokenGenerator())->generate($length);
        $now = new \DateTimeImmutable();
        $expiresAt = $now->setTimestamp($now->getTimestamp() + self::TOKEN_TTL);

        return new self($token, $expiresAt);
    }
}