<?php
namespace Vitvik\Blog\Setup;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $table = $installer->getConnection()->newTable(
            $installer->getTable('vitvik_blog_post')
        )->addColumn(
            'post_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Post ID'
        )->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Post Title'
        )->addColumn(
            'content',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '2M',
            ['nullable' => false],
            'Post Content'
        )->addColumn(
            'creation_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false,'default'=> \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT ],
            'Post Creation Time'
        )->addColumn(
            'update_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false,'default'=> \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
            'Post Modification Time'
        )->addColumn(
            'is_active',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Is Feedback Active'
        )->setComment(
            'Blog Post Table'
        );
        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()->newTable(
            $installer->getTable('vitvik_blog_category')
        )->addColumn(
            'row_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Row ID'
        )->addColumn(
            'post_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false],
            'Post ID'
        )->addColumn(
            'category_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'unsigned' => true],
            'Category ID'
        )->addForeignKey(
            $installer->getFkName(
                'vitvik_blog_category',
                'post_id',
                'vitvik_blog_post',
                'post_id'
            ),
            'post_id',
            $installer->getTable('vitvik_blog_post'),
            'post_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName(
                'vitvik_blog_post',
                'category_id',
                'catalog_category_entity',
                'entity_id'
            ),
            'category_id',
            $installer->getTable('catalog_category_entity'),
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Blog Category Table'
        );
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}