<?php

namespace ZfMetal\Mail\Part;

use Zend\Mime\Part;

class FilePart extends Part
{
    public function __construct($name, $path)
    {
        parent::__construct(fopen($path, 'r'));
        $this->filename = $name;
        $this->disposition = \Zend\Mime\Mime::DISPOSITION_ATTACHMENT;
        $this->encoding = \Zend\Mime\Mime::ENCODING_BASE64;
    }
}