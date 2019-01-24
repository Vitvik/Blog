<?php
namespace Vitvik\Blog\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class Blog extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('vitvik_blog_post', 'post_id');
    }


    public function insertReturnLastId(\Magento\Framework\Model\AbstractModel $object)
    {
        $bind = $this->_prepareDataForSave($object);
        $this->getConnection()->insert($this->getMainTable(), $bind);

        return $this->getConnection()->lastInsertId($this->getMainTable());
    }

}