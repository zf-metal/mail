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
     * @var \ZfMetal\Mail\Transport\TransportInterface
     */
    private $transport;

    /**
     *
     * @var Zend\Mail\Message 
     */
    private $message;

    function getMessage(){
        return $this->message;
    }

    function __construct(\ZfMetal\Mail\Transport\TransportInterface $transport) {
        $this->transport = $transport;
        $this->message = new \Zend\Mail\Message();
    }

    function getTransport() {
        return $this->transport;
    }

    function setTransport(\ZfMetal\Mail\Transport\TransportInterface $transport) {
        $this->transport = $transport;
    }
    
    public function send(){
       $this->getTransport()->send($this->getMessage());
    }

}
