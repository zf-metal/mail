<?php

namespace ZfMetal\Mail\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions {

    /**
     *
     * @var array()
     */
    private $transportOptions;

    /**
     * @var string
     */
    private $transport;

    /**
     * @var string
     */
    private $defaultFrom;

    function getTransportOptions() {
        return $this->transportOptions;
    }

    function getTransport() {
        return $this->transport;
    }

    function setTransportOptions($transportOptions) {
        $this->transportOptions = $transportOptions;
    }

    function setTransport($transport) {
        $this->transport = $transport;
    }

    /**
     * Constructor
     */
    public function __construct($options = null) {
        $this->__strictMode__ = false;
        parent::__construct($options);
    }

    /**
     * @return string
     */
    public function getDefaultFrom()
    {
        return $this->defaultFrom;
    }

    /**
     * @param string $defaultFrom
     */
    public function setDefaultFrom($defaultFrom)
    {
        $this->defaultFrom = $defaultFrom;
    }



}
