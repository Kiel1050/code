<?php

namespace Mageplaza\GiftCard\Block\Customer;

use Magento\Framework\View\Element\Template;

class GiftCard extends Template
{
    protected $helperData;
    protected $_coreSession;

    public function __construct(
        Template\Context $context,
        \Magento\Customer\Model\Session $coreSession,
        \Mageplaza\GiftCard\Helper\Data $helperData
    )
    {
        $this->helperData = $helperData;
        $this->_coreSession = $coreSession;
        parent::__construct($context);
    }

    public function getBalance()
    {
        return $this->_coreSession->getCustomer()->getData('giftcard_balance');
    }

    public  function isRedeemAllowed(){
        return $this->helperData->getGeneralConfig('allow_redeem_gift_card');
    }
}