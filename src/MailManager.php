<?php

namespace ZfMetal\Mail;

/**
 * Description of Mail
 *
 * @author afurgeri
 */
class MailManager {

    /**
     *
     * @var \Zend\Mail\Transport\Smtp
     */
    private $transport;

    /**
     *
     * @var \Zend\Mail\Message
     */
    private $message;

    function getMessage(){
        return $this->message;
    }

    function __construct(\Zend\Mail\Transport\Smtp $transport) {
        $this->transport = $transport;
        $this->message = new \Zend\Mail\Message();
    }

    function getTransport() {
        return $this->transport;
    }

    function setTransport(\Zend\Mail\Transport\Smtp $transport) {
        $this->transport = $transport;
    }
    
    public function send(){
       $this->getTransport()->send($this->getMessage());
    }

}
