<?php

/*
 * This file is part of the FOSOAuthServerBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\OAuthServerBundle;

use FOS\OAuthServerBundle\DependencyInjection\Compiler\TokenStorageCompilerPass;
use FOS\OAuthServerBundle\DependencyInjection\Compiler\RequestStackCompilerPass;
use FOS\OAuthServerBundle\DependencyInjection\FOSOAuthServerExtension;
use FOS\OAuthServerBundle\DependencyInjection\Security\Factory\OAuthFactory;
use FOS\OAuthServerBundle\DependencyInjection\Compiler\GrantExtensionsCompilerPass;
use Symfony\Bundle\SecurityBundle\DependencyInjection\SecurityExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Kernel;

class FOSOAuthServerBundle extends Bundle
{
    public function __construct()
    {
        $this->extension = new FOSOAuthServerExtension();
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        /** @var SecurityExtension $extension */
        $extension = $container->getExtension('security');
        $extension->addAuthenticatorFactory(new OAuthFactory());

        $container->addCompilerPass(new GrantExtensionsCompilerPass());
        $container->addCompilerPass(new TokenStorageCompilerPass());
        $container->addCompilerPass(new RequestStackCompilerPass());
    }
}
