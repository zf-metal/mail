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
        $html->charset = 'utf-8';
        $html->encoding = Mime::ENCODING_QUOTEDPRINTABLE;
    }

    public function addHtmlContent($content = '')
    {
        $this->content .= $content;
    }
}