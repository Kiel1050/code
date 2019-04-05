<?php

namespace Mageplaza\HelloWorld\Controller\Index;

class Example extends \Magento\Framework\App\Action\Action
{

    protected $title;

    public function execute()
    {
        echo $this->setTitle('Welcome','acd','xzc');
        echo 'this'.$this->getTitle('Welcome','acd','xzc');
    }

    public function setTitle($title,$abc,$abc1)
    {
        echo __METHOD__ . "</br>";
        return $this->title = $title;

    }

    public function getTitle($abc,$abc1,$abc2)
    {
        echo __METHOD__ . "</br>";
        return $this->title;

    }
}

