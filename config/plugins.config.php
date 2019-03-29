<?php

namespace ZfMetal\Mail;

use ZfMetal\Mail\Controller\Plugin\Options;
use ZfMetal\Mail\Factory\Controller\Plugin\OptionsFactory;

return [
    'controller_plugins' => [
        'factories' => [
            Controller\Plugin\MailManager::class => Factory\Controller\Plugin\MailManagerFactory::class,
            Options::class => OptionsFactory::class
        ],
        'aliases' => [
            'mailManager' => Controller\Plugin\MailManager::class,
            'ZfMetalMailOptions' => Options::class
        ]
    ]
];
