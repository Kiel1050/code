<?php

namespace Mageplaza\GiftCard\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $random;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Math\Random $random
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->random = $random;
        return parent::__construct($context);
    }

    public
    function execute()
    {

        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('My Gift Card'));
        return $resultPage;
    }
}
