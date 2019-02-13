<?php
/*
 * This file is part of "simple-auth".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleAuth\DependencyInjection;


use SimpleAuth\Controller\SecurityController;
use SimpleAuth\Service\Authenticator\UsernamePasswordAuthenticator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class SimpleAuthExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->addAnnotatedClassesToCompile([
            SecurityController::class,
            UsernamePasswordAuthenticator::class
        ]);
    }
}