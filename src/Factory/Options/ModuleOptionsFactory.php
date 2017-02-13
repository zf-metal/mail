<?php

namespace ZfMetal\Mail\Factory\Options;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


class ModuleOptionsFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
         $config = $container->get('Config');
         
         return new \ZfMetal\Mail\Options\ModuleOptions(isset($config['zf-metal-mail.options']) ? $config['zf-metal-mail.options'] : array());
    }

}
