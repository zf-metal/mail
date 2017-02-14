<?php

namespace ZfMetal\Mail\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Mail\Transport\SmtpOptions as SmtpOptions;

class MailManagerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $moduleOptions = $container->get('zf-metal-mail.options');
        $smptOptions = new SmtpOptions($moduleOptions->getTransportOptions());
        $className = $moduleOptions->getTransport();
        $transport = new $className;

        $transport->setOptions($smptOptions);
        
        return new \ZfMetal\Mail\MailManager($transport);
    }
}
