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

        if (method_exists($transport, 'setOptions')) {
            $transport->setOptions($smptOptions);
        }

        $viewRender = $container->get('ViewRenderer');

        return new \ZfMetal\Mail\MailManager($transport, $viewRender);
    }

}
