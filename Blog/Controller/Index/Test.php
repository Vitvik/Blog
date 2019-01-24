<?php
namespace Vitvik\Blog\Controller\Index;


class Test extends \Magento\Framework\App\Action\Action
{
    protected $pageResultFactory;
    private $collection;
    private $postRepository;

    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageResultFactory,
        \Magento\Framework\App\Action\Context $context,
        \Vitvik\Blog\Model\ResourceModel\Blog\CollectionFactory $collectionFactory,
        \Vitvik\Blog\Model\PostRepository $postRepository

    ) {
        $this->postRepository = $postRepository;
        $this->pageResultFactory = $pageResultFactory;
        $this->collection = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $collectionData = $this->collection->create();

        $test = $this->postRepository->getTitleByCatId('4');

        echo '<pre>';
//        var_dump($collectionData->getData());
//        var_dump($collectionData->getCollectionByCategoryId('4')->getData());
        var_dump($test);
        die();
        $result = $this->pageResultFactory->create();
        return $result;
    }


}
