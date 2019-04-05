<?php

namespace Mageplaza\HelloWorld\Observer;

class bienf implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $bieng)
    {
        $bienh = $bieng->getData('biene');
        echo $bienh->getBienb() . " - Event </br>";
        $bienh->setBienb('Execute event successfully.');
        return $this;
    }
}