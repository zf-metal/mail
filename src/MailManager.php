<?php

namespace ZfMetal\Mail;

use Zend\Log\LoggerAwareInterface;
use Zend\Log\LoggerInterface;
use Zend\Mime\Message;
use ZfMetal\Mail\Part\FilePart;
use ZfMetal\Mail\Part\HtmlPart;

/**
 * Description of Mail
 *
 * @author afurgeri
 */
class MailManager implements LoggerAwareInterface
{

    protected $logger;
    protected $encoding = 'utf8';

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
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

    function getMessage()
    {
        return $this->message;
    }

    /**
     * @return HtmlPart
     */
    public function getHtmlParts()
    {
        return $this->htmlParts;
    }

    function __construct(\Zend\Mail\Transport\TransportInterface $transport, \Zend\View\Renderer\PhpRenderer $viewRender)
    {
        $this->transport = $transport;
        $this->message = new \Zend\Mail\Message();
        $this->message->getHeaders()->setEncoding($this->encoding);
        $this->viewRender = $viewRender;
    }

    function getTransport()
    {
        return $this->transport;
    }

    function setTransport(\Zend\Mail\Transport\TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    public function send()
    {
        if (!$this->getMessage()->getBody()) {
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

    public function setBody($body)
    {
        $this->getMessage()->setBody($body);
        return $this;
    }

    public function setFrom($email, $name = null)
    {
        $this->getMessage()->setFrom($email, $name);
        return $this;
    }

    public function addFrom($email, $name = null)
    {
        $this->getMessage()->addFrin($email, $name);
        return $this;
    }

    public function setTo($email, $name = null)
    {
        $this->getMessage()->setTo($email, $name);
        return $this;
    }

    public function addTo($email, $name = null)
    {
        $this->getMessage()->addTo($email, $name);
        return $this;
    }

    public function setSubject($subject)
    {
        $this->getMessage()->setSubject($subject);
        return $this;
    }

    public function setCc($email)
    {
        $this->getMessage()->setCc($email);
        return $this;
    }

    public function addCc($email)
    {
        $this->getMessage()->addCc($email);
        return $this;
    }

    public function setBcc($email)
    {
        $this->getMessage()->setBcc($email);
        return $this;
    }

    public function addBcc($email)
    {
        $this->getMessage()->addBcc($email);
        return $this;
    }

    /**
     * @param $email
     * @param null $name
     * @return $this
     */
    public function addReplyTo($email, $name = null)
    {
        $this->getMessage()->addReplyTo($email, $name);
        return $this;
    }

    /**
     * @param $partial
     * @param array $params
     * @return $this
     */
    public function setTemplate($partial, $params = [])
    {
        $this->addTemplateWithParams($partial,$params);

        return $this;
    }

    public function attachFile($name, $path)
    {
        try {
            $file = new FilePart($name,$path);
            $body = $this->getMessage()->getBody();
            if (!$body) {
                $body = new Message();
            }
            $body->addPart($file);
            $this->getMessage()->setBody($body);
        } catch (\Exception $e) {
            $this->logger->err($e->getMessage());
            echo $e->getMessage() . PHP_EOL;
            return;
        }
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

    public function setBodyWithHtmlContent($content, $partial, $params)
    {
        //SET MIME PART
        $this->addHtmlContentToBody($content);
        $this->addTemplateWithParams($partial,$params);

        return $this;
    }

    public function addHtmlContentToBody($content)
    {
        $html = new Part\HtmlPart($content);
        $body = $this->getMessage()->getBody();
        if (!$body) {
            $body = new Message();
        }
        $body->addPart($html);
        $this->getMessage()->setBody($body);
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



}
