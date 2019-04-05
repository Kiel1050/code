<?php

namespace Mageplaza\GiftCard\Model\Total\Quote;

class Custom extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{

    protected $_priceCurrency;
    protected $_checkoutSession;
    protected $giftCard;


    public function __construct(
        \Mageplaza\GiftCard\Model\GiftCardFactory $giftCard,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
    )
    {
        $this->giftCard = $giftCard;
        $this->_checkoutSession = $checkoutSession;
        $this->_priceCurrency = $priceCurrency;
    }

    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    )
    {
        parent::collect($quote, $shippingAssignment, $total);

        $giftCardCode = $this->_checkoutSession->getGiftcardCode();
        $giftCard = $this->giftCard->create();
        $amount =  $giftCard->load($giftCardCode, 'code')->getData('balance');

        if ($amount) {
            $baseDiscount = $amount; //giftcard_amount
        } else {
            $baseDiscount = 0;
        }
        $discount = $this->_priceCurrency->convert($baseDiscount);
        $total->addTotalAmount('customdiscount', -$discount); //tru discount
        $total->addBaseTotalAmount('customdiscount', -$baseDiscount); //tru discount
        $total->setBaseGrandTotal($total->getBaseGrandTotal() - $baseDiscount); //tru discount
        $quote->setCustomDiscount(-$discount);


        return $this;
    }

    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $result = null;

        $giftCardCode = $this->_checkoutSession->getGiftcardCode();

        if ($giftCardCode) {
            $giftCard = $this->giftCard->create();
            $amount =  $giftCard->load($giftCardCode, 'code')->getData('balance');
        } else {
            $amount = 0;
        }
        if ($amount != 0) {
            $result = [
                'code' => 'customer_discount',
                'title' => __('gift card ' . $this->_checkoutSession->getGiftcardCode()),
                'value' => -$amount
            ];
        }
        return $result;
    }
}