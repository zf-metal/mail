<?php

namespace ZfMetal\Mail;

use Zend\Log\LoggerAwareInterface;
use Zend\Log\LoggerInterface;

/**
 * Description of Mail
 *
 * @author afurgeri
 */
class MailManager implements LoggerAwareInterface {

    protected $logger;

    public function setLogger(LoggerInterface $logger) {
        $this->logger = $logger;
    }

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

    /**
     *
     * @var \Zend\View\Renderer\PhpRenderer
     */
    private $viewRender;

    function getMessage() {
        return $this->message;
    }

    function __construct(\Zend\Mail\Transport\Smtp $transport, \Zend\View\Renderer\PhpRenderer $viewRender) {
        $this->transport = $transport;
        $this->message = new \Zend\Mail\Message();
        $this->viewRender = $viewRender;
    }

    function getTransport() {
        return $this->transport;
    }

    function setTransport(\Zend\Mail\Transport\Smtp $transport) {
        $this->transport = $transport;
    }

    public function send() {
        if(!$this->getMessage()->getBody()){
            $this->logger->error('El Body no está seteado.');
            return false;
        }
        
        try {
            $this->getTransport()->send($this->getMessage());
            return true;
        } catch (Exception $exc) {
            $this->logger->error($exc->getMessage());
            return false;
        }
    }

    public function setBody($body) {
        $this->getMessage()->setBody($body);
        return $this;
    }

    public function setFrom($email, $name = null) {
        $this->getMessage()->setFrom($email, $name);
        return $this;
    }

    public function addFrom($email, $name = null) {
        $this->getMessage()->addFrin($email, $name);
        return $this;
    }

    public function setTo($email, $name = null) {
        $this->getMessage()->setTo($email, $name);
        return $this;
    }

    public function addTo($email, $name = null) {
        $this->getMessage()->addTo($email, $name);
        return $this;
    }

    public function setSubject($subject) {
        $this->getMessage()->setSubject($subject);
        return $this;
    }

    public function setCc($email) {
        $this->getMessage()->setCc($email);
        return $this;
    }

    public function addCc($email) {
        $this->getMessage()->addCc($email);
        return $this;
    }

    public function setBcc($email) {
        $this->getMessage()->setBcc($email);
        return $this;
    }

    public function addBcc($email) {
        $this->getMessage()->addBcc($email);
        return $this;
    }

    public function addReplyTo($email, $name = null) {
        $this->getMessage()->addReplyTo($email, $name);
        return $this;
    }

    public function setTemplate($partial, $params = []) {
        try {
            //RENDER TEMPLATE
            $viewModel = new \Zend\View\Model\ViewModel();
            $viewModel->setTemplate($partial);
            $viewModel->setVariables($params);
            $render = $this->viewRender->render($viewModel);
        } catch (Exception $exc) {
            $this->logger->error($exc->getMessage());
            return;
        }

        //SET MIME PART
        $html = new \Zend\Mime\Part($render);
        $html->type = \Zend\Mime\Mime::TYPE_HTML;
        $html->charset = 'utf-8';
        $html->encoding = \Zend\Mime\Mime::ENCODING_QUOTEDPRINTABLE;

        //BUILD BODY
        $body = new \Zend\Mime\Message();
        $body->setParts([$html]);

        //SET BODY
        $this->getMessage()->setBody($body);

        return $this;
    }

}
