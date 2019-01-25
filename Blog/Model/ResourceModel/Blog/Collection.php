<?php
namespace Vitvik\Blog\Model\ResourceModel\Blog;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_eventPrefix = 'vitvik_blog_collection';
    protected $_eventObject = 'blog_collection';

    protected function _construct()
    {
        $this->_init(
            \Vitvik\Blog\Model\Blog::class,
            \Vitvik\Blog\Model\ResourceModel\Blog::class
        );
    }

    public function getCollectionWhitCategory(){
        return $this->join(
            ['bc' => 'vitvik_blog_category'],
            "main_table.post_id = bc.post_id",
            ['post_id' => 'main_table.post_id']
        );
    }
    public function getCollectionByCategoryId($categoryId){
        $this->getCollectionWhitCategory()
            ->addFieldToSelect('post_id')
            ->addFieldToSelect('title')
            ->addFieldToFilter('category_id', ["eq" => $categoryId ]);
        return $this;
    }

//SELECT vitvik_blog_post.post_id, vitvik_blog_post.title
//FROM vitvik_blog_post
//INNER JOIN vitvik_blog_category ON vitvik_blog_post.post_id = vitvik_blog_category.post_id
//WHERE vitvik_blog_category.category_id = '6'
//GROUP BY vitvik_blog_post.post_id

}