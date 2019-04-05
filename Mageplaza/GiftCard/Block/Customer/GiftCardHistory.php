<?php

namespace Mageplaza\GiftCard\Block\Customer;

use Magento\Framework\View\Element\Template;

class GiftCardHistory extends Template
{
    protected $_giftCardHistoryFactory;
    protected $_giftCardFactory;
    protected $_coreSession;


    public function __construct(
        Template\Context $context,
        \Mageplaza\GiftCard\Model\GiftCardFactory $giftCardFactory,
        \Magento\Customer\Model\Session $coreSession,
        \Mageplaza\GiftCard\Model\GiftCardHistoryFactory $giftCardHistoryFactory

    )
    {
        $this->_giftCardFactory = $giftCardFactory;
        $this->_giftCardHistoryFactory = $giftCardHistoryFactory;
        $this->_coreSession = $coreSession;
        parent::__construct($context);
    }

    public function getHistory()
    {
        $history = $this->_giftCardHistoryFactory->create();
        $collection = $history->getCollection();
        $customerId = $this->_coreSession->getCustomer()->getData('entity_id');
        $collection->addFieldToFilter('customer_id', $customerId)->setOrder('history_id', 'DESC');
        return $collection->getData(); //FIXME
    }

    public function getCode($id)
    {
        $giftCard = $this->_giftCardFactory->create();
        return $giftCard->load($id)->getData('code');
    }
}