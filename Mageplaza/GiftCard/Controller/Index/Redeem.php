<?php

namespace Mageplaza\GiftCard\Controller\Index;

class Redeem extends \Magento\Framework\App\Action\Action
{
    protected $_giftCardFactory;
    protected $_giftCardHistoryFactory;
    protected $customerResource;
    protected $customerFactory;
    protected $_coreSession;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Mageplaza\GiftCard\Model\GiftCardFactory $giftCardFactory,
        \Mageplaza\GiftCard\Model\GiftCardHistoryFactory $giftCardHistoryFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Model\Session $coreSession,
        \Magento\Customer\Model\ResourceModel\Customer $customerResource
    )
    {
        $this->_giftCardFactory = $giftCardFactory;
        $this->_giftCardHistoryFactory = $giftCardHistoryFactory;
        $this->customerResource = $customerResource;
        $this->customerFactory = $customerFactory;
        $this->_coreSession = $coreSession;

        return parent::__construct($context);
    }

    public function execute()
    {
        $giftCard = $this->_giftCardFactory->create();
        $history = $this->_giftCardHistoryFactory->create();
        $customer = $this->customerFactory->create();
        $customerId = $this->_coreSession->getCustomer()->getData()['entity_id'];
        $customer->load($customerId);

//        var_dump($this->_coreSession->getCustomer()->getData()['entity_id']);
//        die('1');

        $success = False;
        $item = $giftCard->load($this->getRequest()->getParam('redeem'), 'code')->getData();

        if (isset($item)) {
            //684VCUPV5XVL
            //check amount used
            if ($item['balance'] > $item['amount_used']) {
                // add history
                $data = array('giftcard_id' => $item['giftcard_id'], 'customer_id' => $customerId, 'amount' => $item['balance'], 'action' => 'redeem');
                var_dump($data);
                $history->addData($data)->save();

                //add customer_entity
                $balance = $customer->getData()['giftcard_balance'] + $item['balance'];
                $customer->addData(array('giftcard_balance' => $balance));
                $this->customerResource->getConnection()->update(
                    $this->customerResource->getTable('customer_entity'),
                    [
                        'giftcard_balance' => $balance,
                    ],
                    $this->customerResource->getConnection()->quoteInto('entity_id = ?', $customerId)
                );

                //add giftcard amount used
                $giftCard->addData(array('amount_used' => $item['balance']))->save();
                //success
                $success = True;
            }

        }

        if ($success) {
            $this->messageManager->addSuccess(__('The code has been redeem.'));
        } else {
            $this->messageManager->addError(__('The code no longer exists or used'));
        }

        $this->_redirect('giftcard');
    }
}
