<?php

namespace ZfMetal\Mail;

return [
    'service_manager' => [
        'factories' => [
            'zf-metal-mail.options' => Factory\Options\ModuleOptionsFactory::class,
            MailManager::class => Factory\MailManagerFactory::class,
        ],
    ]
];

