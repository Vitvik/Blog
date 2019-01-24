<?php
namespace Vitvik\Blog\Controller\Adminhtml\Index;

use Magento\Framework\Exception\LocalizedException;
use \Magento\Backend\App\Action;
class Save extends Action
{
    private $blogFactory;
    private $blogResource;
    private $categoryFactory;
    private $categoryResource;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Vitvik\Blog\Model\BlogFactory $blogFactory,
        \Vitvik\Blog\Model\ResourceModel\Blog $blogResource,
        \Vitvik\Blog\Model\BlogCategoryFactory $categoryFactory,
        \Vitvik\Blog\Model\ResourceModel\BlogCategory $categoryResource
    )
    {
        $this->blogFactory = $blogFactory;
        $this->blogResource = $blogResource;
        $this->categoryFactory = $categoryFactory;
        $this->categoryResource = $categoryResource;
        parent::__construct($context);
    }
    public function execute()
    {
        $result = $this->resultRedirectFactory->create();

        if($post = $this->getRequest()->getPostValue()){
            $data[] = $post['data'];
            $categories = $this->categoryFactory->create();
            $categoryIds = $categories->prepareCategoriesId($data);
            unset($post['data']);
            try{
                $this->validatePost($post);
                $blog = $this->blogFactory->create();
                $blog->setData($post);
                if(!empty($blog->getData('post_id'))){
                    $postId = $blog->getData('post_id');
                    $this->blogResource->save($blog);
                    $this->categoryResource->saveCategoriesRelations($postId, $categoryIds);
                }
                //$blog->unsetData('data');
                else {
                    $lastId = $this->blogResource->insertReturnLastId($blog);
                    $this->categoryResource->saveCategoriesRelations($lastId, $categoryIds);
                }
                $this->messageManager->addSuccessMessage(
                    __('Thank you for your post.')
                );
            }catch (\Exception $e){
                $this->messageManager->addErrorMessage(
                    __('An error occurred while processing your form. Please try again later.')
                );
                $result->setPath('*/*/');
                return $result;
            }
        }
        $result->setPath('*/*/index');
        return $result;
    }

    private function validatePost($post){
        if(!isset($post['title']) || trim($post['title']) === ''){
            throw new LocalizedException(__('Title is missing'));
        }
        if(!isset($post['content']) || trim($post['content']) === ''){
            throw new LocalizedException(__('Content is missing'));
        }
    }
}