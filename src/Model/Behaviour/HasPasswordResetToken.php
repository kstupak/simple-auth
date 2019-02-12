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

use Toolbox\Utility\TokenGenerator;

trait HasPasswordResetToken
{
    /** @var string */
    private $resetToken;

    public function getResetToken(): string
    {
        return $this->resetToken;
    }

    private function resetToken(int $tokenLength)
    {
        $this->resetToken = strtoupper((new TokenGenerator())->generate($tokenLength));
    }
}