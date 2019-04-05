<?php

namespace Mageplaza\HelloWorld\Plugin;

class ExamplePlugin1
{




    public function aroundGetTitle(\Mageplaza\HelloWorld\Controller\Index\Example $subject,callable $proceed,$abc,$abc1,$abc2)
    {

        echo __METHOD__ . " - Before proceed abc () </br>";
        $result = $proceed($abc,$abc1,$abc2);
        echo __METHOD__ . " - After proceed() </br>";


        return $result;
    }

}
