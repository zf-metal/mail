<?php

namespace ZfMetal\Mail\Controller\Plugin;

/**
 * Options
 *
 * @author
 * @license
 * @link
 */
class Options extends \Zend\Mvc\Controller\Plugin\AbstractPlugin
{

    private $moduleOptions = null;

    public function __construct(\ZfMetal\Mail\Options\ModuleOptions $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * @return \ZfMetal\Mail\Options\ModuleOptions
     */
    public function __invoke()
    {
        return $this->moduleOptions;
    }


}

