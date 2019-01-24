<?php
namespace Vitvik\Blog\Model\ResourceModel;
class BlogCategory extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('vitvik_blog_category', 'row_id');
    }

    public function saveCategoriesRelations($postId, $categoriesIds)
    {
        $savedCategoriesIds = $this->loadCategoryRelations($postId);
        $CategoriesIdsToAdd = array_diff($categoriesIds, $savedCategoriesIds);
        $CategoriesIdsToDelete = array_diff($savedCategoriesIds, $categoriesIds);

        $dataToAdd = [];
        foreach ($CategoriesIdsToAdd as $categoryId) {
            $dataToAdd[] = ['post_id' => $postId, 'category_id' => $categoryId];
        }
        $this->getConnection()->insertMultiple($this->getTable('vitvik_blog_category'), $dataToAdd);

        $this->getConnection()->delete(
            $this->getTable('vitvik_blog_category'),
            ['post_id = ?' => $postId, 'category_id IN (?)' => $CategoriesIdsToDelete]
        );
        return $this;
    }

    public function  loadCategoryRelations($postId)
    {
        $adapter = $this->getConnection();

        $select = $adapter->select()
            ->from($this->getTable('vitvik_blog_category'), 'category_id')
            ->where('post_id = ?', (int)$postId);
        return $adapter->fetchCol($select);
    }

}