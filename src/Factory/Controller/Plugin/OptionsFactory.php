<?php

namespace ZfMetal\Mail\Factory\Controller\Plugin;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * OptionsFactory
 *
 *
 *
 * @author
 * @license
 * @link
 */
class OptionsFactory implements FactoryInterface
{

    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        $servicio = $container->get('zf-metal-mail.options');
        return new \ZfMetal\Mail\Controller\Plugin\Options($servicio);
    }


}

