<?php

namespace Mageplaza\GiftCard\Block\Adminhtml\Code;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected $_coreRegistry;

    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    )
    {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'giftcard_id';
        $this->_blockGroup = 'Mageplaza_GiftCard';
        $this->_controller = 'adminhtml_code';
        parent::_construct();

        $objId = $this->getRequest()->getParam('id');

        if (!empty($objId)) {
            $this->addButton(
                'delete',
                [
                    'label' => __('Delete'),
                    'class' => 'delete',
                    'onclick' => 'deleteConfirm(\'' . __(
                            'Are you sure you want to do this?'
                        ) . '\', \'' . $this->getDeleteUrl() . '\')'
                ]
            );
        }

        $this->buttonList->add(
            'saveandcontinue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'saveAndContinueEdit',
                            'target' => '#edit_form'
                        ]
                    ]
                ]
            ],
            -100
        );
    }

    public function getDeleteUrl(array $args = [])
    {
        //die('1');
        return $this->getUrl('giftcard/code/delete', ['id' => $this->getRequest()->getParam('id')]);    }
}
