<?php

namespace ZfMetal\Mail\Part;

use Zend\Mime\Mime;
use Zend\Mime\Part;

class HtmlPart extends Part
{
    public function __construct($content = '')
    {
        parent::__construct($content);
        $this->setType(Mime::TYPE_HTML);
        $this->charset = 'utf-8';
        $this->encoding = Mime::ENCODING_QUOTEDPRINTABLE;
    }
}