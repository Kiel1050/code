<?php

namespace Mageplaza\GiftCard\Controller\Adminhtml\Code;

class Delete extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Mageplaza\GiftCard\Model\GiftCardFactory $giftCardFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->_giftCardFactory = $giftCardFactory;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $giftCard = $this->_giftCardFactory->create();
        $id = $this->getRequest()->getParam('id');

        $giftCard->load($id);   //delete
        $giftCard->delete();
        $this->messageManager->addSuccess(__('The code has been deleted.'));
        $this->_redirect('*/*/');
    }


}