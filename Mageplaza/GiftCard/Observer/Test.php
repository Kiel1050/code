<?php

namespace Mageplaza\GiftCard\Observer;

use \Magento\Framework\Event\Observer;
use \Magento\Framework\Event\ObserverInterface;

class Test implements ObserverInterface
{

    public function __construct()
    {

    }

    public function execute(Observer $observer)
    {
        var_dump($observer->getControllerAction()->getRequest()->getParams());
        var_dump($_REQUEST);
        echo "<br>Hello World 2<br>";
    }
}