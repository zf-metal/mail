<?php

namespace ZfMetal\Mail\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class MailManagerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $moduleOptions = $container->get('zf-metal-mail.options');
        $smptOptions = \Zend\Mail\Transport\SmtpOptions($moduleOptions->getTransportOptions());
        
        $transport = new $moduleOptions->getTransport();
        $transport->setOptions($smptOptions);
        
        return new \ZfMetal\Mail\MailManager($transport);
    }
}
