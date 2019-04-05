<?php

namespace Mageplaza\HelloWorld\Controller\Index;

class Test extends \Magento\Framework\App\Action\Action
{

    public function execute()
    {
        $biena = new \Magento\Framework\DataObject(array('bienb' => 'bienc'));
        $this->_eventManager->dispatch('biend', ['biene' => $biena]);
        echo $biena->getBienb();
        exit;
    }
}