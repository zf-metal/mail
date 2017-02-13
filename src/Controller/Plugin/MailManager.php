<?php

namespace ZfMetal\Mail\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class MailManager extends AbstractPlugin {
    
    /**
     *
     * @var \ZfMetal\Mail\MailManager
     */
    private $mail;
    
    public function __invoke() {
        return $this->getMail();
    }

        public function getMail() {
        return $this->mail;
    }

    function setMail(\ZfMetal\Mail\MailManager $mail) {
        $this->mail = $mail;
    }

    function __construct(\ZfMetal\Mail\MailManager $mail) {
        $this->mail = $mail;
    }
    
    
    
}
