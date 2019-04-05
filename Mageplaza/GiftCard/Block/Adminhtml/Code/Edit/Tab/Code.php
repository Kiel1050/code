<?php

namespace Mageplaza\GiftCard\Block\Adminhtml\Code\Edit\Tab;

class Code extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $helperData;
    protected $_giftCardFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Mageplaza\GiftCard\Helper\Data $helperData,
        \Mageplaza\GiftCard\Model\GiftCardFactory $giftCardFactory,
        array $data = []
    )
    {
        $this->helperData = $helperData;
        $this->_giftCardFactory = $giftCardFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $form = $this->_formFactory->create();
        $form->setFieldNameSuffix('code');
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Gift card information')]
        );

        $codeId = $this->getRequest()->getParam('id');
        //die($codeId);
        if (isset($codeId)) {
            $giftCard = $this->_giftCardFactory->create(); //lay thong tin gift code
            $fieldset->addField(
                'giftcard_id',
                'hidden',
                [
                    'name' => 'id',
                    'label' => __('giftcard_id'),
                    'value' => $codeId,
                    'readonly' => true,
                ]
            );
            $fieldset->addField(
                'code',
                'text',
                [
                    'name' => 'code',
                    'label' => __('Code'),
                    'value' => $giftCard->load($codeId)->getData()['code'],
                    'readonly' => true,
                ]
            );
            $fieldset->addField(
                'balance',
                'text',
                [
                    'name' => 'Balance',
                    'label' => __('Balance'),
                    'required' => true,
                    'value' => $giftCard->load($codeId)->getData()['balance'],
                ]
            );
            $fieldset->addField(
                'create_from',
                'text',
                [
                    'name' => 'create_from',
                    'label' => __('Create From'),
                    'value' => $giftCard->load($codeId)->getData()['create_from'],
                    'readonly' => true,
                ]
            );
        } else {
            $fieldset->addField(
                'code_length',
                'text',
                [
                    'name' => 'Code Length',
                    'label' => __('Code Length'),
                    'value' => $this->helperData->getCodeConfig('code_length'),
                    'class' =>'validate-greater-than-zero integer',
                ]
            );
            $fieldset->addField(
                'balance',
                'text',
                [
                    'name' => 'Balance',
                    'label' => __('Balance'),
                    'required' => true
                ]
            );
        }

        $this->setForm($form);
        return parent::_prepareForm();
    }


    public function getTabLabel()
    {
        return __('Gift card information');
    }

    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}
