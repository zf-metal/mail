<?php

namespace ZfMetal\Mail\Factory\Controller\Plugin;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class MailManagerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $mail =  $container->get(\ZfMetal\Mail\MailManager::class);
        
        return new \ZfMetal\Mail\Controller\Plugin\MailManager($mail);
    }

}
