<?php

namespace Mageplaza\HelloWorld\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

    const XML_PATH_HELLOWORLD = 'helloworld/';

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopapp/code/Mageplaza/HelloWorld/Setup/InstallSchema.phpeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    public function getGeneralConfig($code, $storeId = null)
    {

        return $this->getConfigValue(self::XML_PATH_HELLOWORLD .'general/'. $code, $storeId);
    }

}