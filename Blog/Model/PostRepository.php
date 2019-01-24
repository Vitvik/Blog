<?php
namespace Vitvik\Blog\Model;

use Vitvik\Blog\Api\Data\PostInterface;
use Vitvik\Blog\Api\Data\PostSearchResultInterface;
use Vitvik\Blog\Api\Data\PostSearchResultInterfaceFactory;
use Vitvik\Blog\Api\PostRepositoryInterface;
use Vitvik\Blog\Model\ResourceModel\Blog as PostResource;
use Vitvik\Blog\Model\BlogFactory as PostFactory;
use Vitvik\Blog\Model\ResourceModel\Blog\Collection as PostCollection;
use Vitvik\Blog\Model\ResourceModel\Blog\CollectionFactory as PostCollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Vitvik\Blog\Model\ResourceModel\BlogCategory as CategoryResource;

/**
 * Class PostRepository
 * @package Vitvik\Blog\Model
 */
class PostRepository implements PostRepositoryInterface
{
    const POST_PATH = '/blog/index/post/';
    /**
     * @var array
     */
    private $registry = [];

    /**
     * @var PostResource
     */
    private $postResource;

    /**
     * @var PostResource
     */
    private $categoryResource;


    /**
     * @var PostFactory
     */
    private $postFactory;

    /**
     * @var PostCollectionFactory
     */
    private $postCollectionFactory;

    /**
     * @var PostSearchResultInterfaceFactory
     */
    private $postSearchResultFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param PostResource $postResource
     * @param PostResource $categoryResource
     * @param PostFactory $postFactory
     *  @param Post $post
     * @param PostCollectionFactory $postCollectionFactory
     * @param PostSearchResultInterfaceFactory $postSearchResultFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        PostResource $postResource,
        CategoryResource $categoryResource,
        PostFactory $postFactory,
        PostCollectionFactory $postCollectionFactory,
        PostSearchResultInterfaceFactory $postSearchResultFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->postResource = $postResource;
        $this->categoryResource = $categoryResource;
        $this->postFactory = $postFactory;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->postSearchResultFactory = $postSearchResultFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save Page data
     *
     * @param \Vitvik\Blog\Api\Data\PostInterface $post
     * @return \Vitvik\Blog\Api\Data\PostInterface
     * @throws CouldNotSaveException
     */
    public function save(PostInterface $post)
    {
        try {
            $this->postResource->save($post);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the post: %1', $exception->getMessage()),
                $exception
            );
        }
        return $post;
    }
    /**
     * @param $id
     * @return PostInterface
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        if (!array_key_exists($id, $this->registry)) {
            $post = $this->postFactory->create();
            $this->postResource->load($post, $id);
            if (!$post->getId()) {
                throw new NoSuchEntityException(__('Requested post does not exist'));
            }
            $this->registry[$id] = $post;
        }

        return $this->registry[$id];
    }

    /**
     * @param int $categoryId
     * @return array
     * @throws NoSuchEntityException
     */

    public function getTitleByCatId($categoryId)
    {
        $collection = $this->postCollectionFactory->create();
//        $arr = $collection->getCollectionByCategoryId($categoryId)->getData();
        $collection->getCollectionByCategoryId($categoryId);
        foreach ($collection as $post) {
            $post->appendUrl();
        }
        return $collection->getData();
//        $data =[];
//        foreach ($arr as $value){
//            $data[] = array_merge($value, array('url'=>self::POST_PATH .$value['post_id']));
//        }
//        return  $data;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Vitvik\Blog\Api\Data\PostSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {

        $collection = $this->postCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        /** @var \Vitvik\Blog\Api\Data\PostSearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
    /**
     * Delete Post
     *
     * @param \Vitvik\Blog\Api\Data\PostInterface $post
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(PostInterface $post)
    {
        try {
            $this->postResource->delete($post);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the post: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }
    /**
     * Delete Post by given Post Id
     *
     * @param string $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

}