<?php
namespace Vitvik\Blog\Block;


class BlogList extends \Magento\Framework\View\Element\Template
{
    const PAGE_SIZE = 5;

    private $collectionFactory;
    private $collection;
    private $blogResource;
    private $timezone;
    private $coreRegistry;
    protected $post;


    public function  __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Vitvik\Blog\Model\ResourceModel\Blog\CollectionFactory $collectionFactory,
        \Vitvik\Blog\Model\ResourceModel\Blog $blogResource,
        \Magento\Framework\Stdlib\DateTime\Timezone $timezone,
        \Magento\Framework\Registry $coreRegistry,
        \Vitvik\Blog\Api\PostRepositoryInterface $post,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->blogResource = $blogResource;
        $this->timezone = $timezone;
        $this->coreRegistry = $coreRegistry;
        $this->post = $post;
    }

    public function getBlogCollection()
    {
        if(!$this->collection){
            $this->collection = $this->collectionFactory->create();
            $this->collection->addFieldToFilter('is_active', 1);
            $this->collection->setOrder('creation_time', 'DESC');
        }
        return $this->collection;
    }

    public function getPagerHtml()
    {
        $pagerBlock = $this->getChildBlock('blog_list_pager');
         if ($pagerBlock instanceof \Magento\Framework\DataObject){
            $pagerBlock
                ->setUseContainer(false)
                ->setShowPerPage(false)
                ->setShowAmounts(false)
                ->setLimit($this->getLimit())
                ->setCollection($this->getBlogCollection());
            return $pagerBlock->toHtml();
        }
        return '';
    }

    public function getLimit()
    {
        return static::PAGE_SIZE;
    }



    public function getPostDate($post)
    {
        return $this->timezone->formatDateTime($post->getCreationTime());
    }

    public function getControllerId()
    {
        return $this->coreRegistry->registry('POST_ID');
    }

    public function getPostById($id)
    {
        return $this->post->getById($id);
    }

}