<?php

namespace Mageplaza\GiftCard\Controller\Adminhtml\Code;

class Edit extends \Magento\Backend\App\Action
{

    protected $_resultPageFactory;

    public function __construct(
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }


    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        if ($this->getRequest()->getParam('id')) {
            $resultPage->getConfig()->getTitle()->prepend((__('Edit Gift Card')));
        } else {
            $resultPage->getConfig()->getTitle()->prepend((__('New Gift Card')));
        }
        return $resultPage;
    }
}
