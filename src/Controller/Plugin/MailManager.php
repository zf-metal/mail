<?php

namespace ZfMetal\Mail\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class MailManager extends AbstractPlugin {
    
    /**
     *
     * @var \ZfMetal\Mail\Mail
     */
    private $mail;
    
    function getMail() {
        return $this->mail;
    }

    function setMail(\ZfMetal\Mail\Mail $mail) {
        $this->mail = $mail;
    }

    function __construct(\ZfMetal\Mail\Mail $mail) {
        $this->mail = $mail;
    }

    
    
}
