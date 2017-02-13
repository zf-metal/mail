<?php

namespace ZfMetal\Security;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controller_plugins' => [
        'factories' => [
            \ZfMetal\Mail\Controller\Plugin\MailManager::class => \ZfMetal\Mail\Factory\Controller\Plugin\MailManager::class,
        ],
        'aliases' => [
            'mailManager' => \ZfMetal\Mail\Controller\Plugin\MailManager::class,
        ]
    ]
];
