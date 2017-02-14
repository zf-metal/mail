<?php

namespace ZfMetal\Mail;

return [
    'service_manager' => [
        'factories' => [
            'zf-metal-mail.options' => Factory\Options\ModuleOptionsFactory::class,
            \ZfMetal\Mail\MailManager::class => \ZfMetal\Mail\Factory\MailManagerFactory::class,
        ],
    ]
];

