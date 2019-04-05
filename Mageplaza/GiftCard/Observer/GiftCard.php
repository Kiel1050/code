<?php

namespace Mageplaza\GiftCard\Observer;

use \Magento\Framework\Event\Observer;
use \Magento\Framework\Event\ObserverInterface;

class GiftCard implements ObserverInterface
{
    protected $giftcardModel;
    protected $random;
    protected $helperData;
    protected $history;
    protected $product;

    public function __construct(
        \Mageplaza\GiftCard\Model\GiftCardFactory $giftcardModel,
        \Magento\Framework\Math\Random $random,
        \Mageplaza\GiftCard\Helper\Data $helperData,
        \Mageplaza\GiftCard\Model\GiftCardHistoryFactory $history,
        \Magento\Catalog\Model\ProductFactory $product

    )
    {
        $this->giftcardModel = $giftcardModel;
        $this->random = $random;
        $this->helperData = $helperData;
        $this->history = $history;
        $this->product = $product;

    }

    public function randomCodeWithLength($length)
    {
        $str = 'ABCDEFGHIJKLMLOPQRSTUVXYZ0123456789';
        return $this->random->getRandomString($length, $str);
    }

    public function execute(Observer $observer)
    {
        //get data event TODO
        $product = $this->product->create();
        $orderObject = $observer->getData('order'); //object
        $quoteObject = $observer->getData('quote'); //object
        $orderId = $orderObject->getIncrementId();
        $customerId = $orderObject->getCustomerId();
        $item = $quoteObject->getAllItems();

        foreach ($item as $item) {
            $productId = $item->getProductId();
            $balance = $product->load($productId)->getData('giftcard_amount');
            if ($item->getIsVirtual() && $balance > 0) {
                $quantity = $item->getQty();
                $length = $this->helperData->getCodeConfig('code_length');
                $createFrom = 'Order #' . $orderId;
                for ($i = 0; $i < $quantity; $i++) {
                    //create new code
                    $giftcardModel = $this->giftcardModel->create();
                    $code = $this->randomCodeWithLength($length);
                    $giftcardModel->addData(array('code' => $code, 'create_from' => $createFrom, 'balance' => $balance))->save();
                    //add history
                    $history = $this->history->create();
                    $giftcardId = $giftcardModel->getID();
                    $data = array('giftcard_id' => $giftcardId, 'customer_id' => $customerId, 'amount' => $balance, 'action' => 'create #' . $orderId);
                    $history->addData($data)->save();
                }
            }
        }
    }
}

