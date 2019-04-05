<?php

namespace Mageplaza\GiftCard\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('giftcard_code')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('giftcard_code')
            )
                ->addColumn(
                    'giftcard_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                        'unsigned' => true,
                    ],
                    'Gift Card Id'
                )
                ->addColumn(
                    'code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    [],
                    'Code'
                )
                ->addColumn(
                    'balance',
                    \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '12,4',
                    [],
                    'Balance'
                )
                ->addColumn(
                    'amount_used',
                    \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '12,4',
                    [],
                    'Amount Used'
                )
                ->addColumn(
                    'create_from',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    [

                    ],
                    'Create From'
                )
                ->addColumn(
                    'create_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                    null,
                    [

                    ],
                    'Create At'
                );
            $installer->getConnection()->createTable($table);


        }
        $installer->endSetup();
    }
}