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

}
