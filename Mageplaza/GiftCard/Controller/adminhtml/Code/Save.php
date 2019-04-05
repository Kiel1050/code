<?php

namespace Mageplaza\GiftCard\Controller\adminhtml\Code;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Mageplaza\GiftCard\Model\GiftCardFactory;
use Mageplaza\GiftCard\Controller\Adminhtml\Code;

class Save extends Action
{
    protected $_coreRegistry;
    protected $_resultPageFactory;
    protected $_giftCardFactory;
    protected $date;
    protected $random;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        GiftCardFactory $giftCardFactory,
        \Magento\Framework\Math\Random $random
    )
    {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_giftCardFactory = $giftCardFactory;
        $this->random = $random;
    }

//    protected function _isAllowed()
//    {
//        return $this->_authorization->isAllowed('Mageplaza_GiftCard::managecodes');
//    }

    public function randomCodeWithLength($length)
    {
        $str = 'ABCDEFGHIJKLMLOPQRSTUVXYZ0123456789';
        return $this->random->getRandomString($length, $str);
    }

    public function execute()
    {
        $isPost = $this->getRequest()->getPost();
        if ($isPost) {
            $newsModel = $this->_giftCardFactory->create();
            try {
                // Save code
                $data = $this->getRequest()->getParam('code');
                $error = false;
                if (!isset($data['id'])) {//save new giftcode
                    $code = $this->randomCodeWithLength($data['Code Length']);
                    $newsModel->addData(array('code' => $code, 'create_from' => 'Admin', 'balance' => $data['Balance']))->save();
                } else {//save edited giftcode
                    $id = $data['id'];
                    $newsModel->load($id);
                    if (!$newsModel->getData() == '') { //kiem tra xem giftcode co ton tai khong
                        $newsModel->addData(array('balance' => $data['Balance']))->save();
                    } else {
                        $this->messageManager->addError(__('The code no longer exists'));
                        $error = true;
                    };
                }
                // Display success message
                if (!$error) {
                    $this->messageManager->addSuccess(__('The code has been saved.'));
                }

                // Check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $newsModel->getId()]);
                    return;
                }

                // Go to grid page
                $this->_redirect('*/*/');
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }

            //$this->_getSession()->setFormData($formData);
            //die('4');
            //$this->_redirect('*/*/');
            //$this->_redirect('*/*/edit', ['id' => $newsId]);
        }
    }
}