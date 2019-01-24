<?php
namespace Vitvik\Blog\Ui\DataProvider\Listing;
use Vitvik\Blog\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    protected $collection;


    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->collection->getSelect()
        ->join(
            ['bc' => 'vitvik_blog_category'],
            "main_table.post_id = bc.post_id",
            ['post_id' => 'main_table.post_id']

        )
        ->join(
            ['cv' => 'catalog_category_entity_varchar'],
            "bc.category_id = cv.entity_id",
            [
            'category' =>  'GROUP_CONCAT(cv.value SEPARATOR \'| \')'
        ]
        )
        ->where('cv.attribute_id = 45')
        ->group("main_table.post_id");

    }
    /*
SELECT vitvik_blog_post.post_id, vitvik_blog_post.title, vitvik_blog_post.content, vitvik_blog_post.creation_time, vitvik_blog_post.update_time, vitvik_blog_post.is_active,
GROUP_CONCAT(catalog_category_entity_varchar.value SEPARATOR ', ')
FROM vitvik_blog_post
INNER JOIN vitvik_blog_category
ON vitvik_blog_post.post_id = vitvik_blog_category.post_id
INNER JOIN catalog_category_entity_varchar
ON vitvik_blog_category.category_id = catalog_category_entity_varchar.entity_id
GROUP BY vitvik_blog_post.post_id
*/

}


