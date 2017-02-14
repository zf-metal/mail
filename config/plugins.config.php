<?php

namespace ZfMetal\Mail;

return [
    'controller_plugins' => [
        'factories' => [
            Controller\Plugin\MailManager::class => Factory\Controller\Plugin\MailManagerFactory::class,
        ],
        'aliases' => [
            'mailManager' => Controller\Plugin\MailManager::class ,
        ]
    ]
];
