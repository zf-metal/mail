<?php

namespace ZfMetal\Mail;

use Zend\Log\LoggerAwareInterface;
use Zend\Log\LoggerInterface;
use ZfMetal\Mail\Part\HtmlPart;

/**
 * Description of Mail
 *
 * @author afurgeri
 */
class MailManager implements LoggerAwareInterface {

    protected $logger;
    protected $encoding = 'utf8';
    /**
     * @var HtmlPart
     */
    protected $htmlParts;

    public function setLogger(LoggerInterface $logger) {
        $this->logger = $logger;
        $this->htmlParts = new Part\HtmlPart();
    }

    /**
     *
     * @var \Zend\Mail\Transport\TransportInterface
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

    /**
     * @return HtmlPart
     */
    public function getHtmlParts()
    {
        return $this->htmlParts;
    }

    function __construct(\Zend\Mail\Transport\TransportInterface $transport, \Zend\View\Renderer\PhpRenderer $viewRender) {
        $this->transport = $transport;
        $this->message = new \Zend\Mail\Message();
        $this->message->getHeaders()->setEncoding($this->encoding);
        $this->viewRender = $viewRender;
    }

    function getTransport() {
        return $this->transport;
    }

    function setTransport(\Zend\Mail\Transport\TransportInterface $transport) {
        $this->transport = $transport;
    }

    public function send() {
        if(!$this->getMessage()->getBody()){
            $this->logger->err('El Body no está seteado.');
            return false;
        }

        try {
            $this->getTransport()->send($this->getMessage());
            return true;
        } catch (\Exception $exc) {
            $this->logger->err($exc->getMessage());
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
        } catch (\Exception $exc) {
            $this->logger->err($exc->getMessage());
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

    public function attachFile($name, $path){
        $file = new \Zend\Mime\Part(fopen($path, 'r'));
        $file->filename = $name;
        $file->disposition = \Zend\Mime\Mime::DISPOSITION_ATTACHMENT;
        $file->encoding = \Zend\Mime\Mime::ENCODING_BASE64;

        $parts = $this->getMessage()->getBody()->getParts();
        $parts[] = $file;

        $body = $this->getMessage()->getBody();

        $body->setParts($parts);

        $this->getMessage()->setBody($body);

        $contentTypeHeader = $this->getMessage()->getHeaders()->get('Content-Type');
        $contentTypeHeader->setType('multipart/mixed');
    }

    /**
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * @param string $encoding
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
        $this->getMessage()->getHeaders()->setEncoding($this->encoding);
    }

    public function setBodyWithHtmlContent($content,$partial,$params)
    {
        //SET MIME PART
        $html           = new \Zend\Mime\Part($content);
        $html->type     = \Zend\Mime\Mime::TYPE_HTML;
        $html->charset  = 'utf-8';
        $html->encoding = \Zend\Mime\Mime::ENCODING_QUOTEDPRINTABLE;

        try {
            //RENDER TEMPLATE
            $viewModel = new \Zend\View\Model\ViewModel();
            $viewModel->setTemplate($partial);
            $viewModel->setVariables($params);
            $render = $this->viewRender->render($viewModel);
        } catch (\Exception $exc) {
            $this->logger->err($exc->getMessage());
            return;
        }

        //SET MIME PART
        $su = new \Zend\Mime\Part($render);
        $su->type = \Zend\Mime\Mime::TYPE_HTML;
        $su->charset = 'utf-8';
        $su->encoding = \Zend\Mime\Mime::ENCODING_QUOTEDPRINTABLE;
        //BUILD BODY
        $body           = new \Zend\Mime\Message();
        $body->setParts([$html,$su]);
        $this->setBody($body);
        return $this;
    }

    public function addHtmlContentToBody($content)
    {
        $this->getHtmlParts()->addHtmlContent($content);
        $this->setHtmlPartsOnBody();
    }

    public function addTemplateWithParams($template, $params = [])
    {

        try {
            //RENDER TEMPLATE
            $viewModel = new \Zend\View\Model\ViewModel();
            $viewModel->setTemplate($template);
            $viewModel->setVariables($params);
            $render = $this->viewRender->render($viewModel);
        } catch (\Exception $exc) {
            $this->logger->err($exc->getMessage());
            return;
        }

        $this->addHtmlContentToBody($render);
    }

    private function setHtmlPartsOnBody()
    {
        $body = new \Zend\Mime\Message();
        $body->setParts([$this->getHtmlParts()]);
        $this->setBody($body);
    }


}
