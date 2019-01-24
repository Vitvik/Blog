<?php
namespace Vitvik\Blog\Controller\Adminhtml\Index;

use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\App\Action\Context;
class Delete extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Vitvik_Blog::post_delete';

    private $postResource;
    private $postFactory;
    private $postRepository;

    public function __construct(
        Context $context,
        \Vitvik\Blog\Api\PostRepositoryInterface $postRepository,
        \Vitvik\Blog\Model\ResourceModel\Blog $postResource,
        \Vitvik\Blog\Model\BlogFactory $postFactory
    ) {
        $this->postRepository = $postRepository;
        $this->postFactory = $postFactory;
        $this->postResource = $postResource;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
//        $post = $this->postFactory->create();

        $id = $this->getRequest()->getParam('post_id');
        if ($id) {
            try {
                $this->postRepository->deleteById($id);
     //           $post->load($id);
     //           $post->delete();
     //         $this->postResource->delete($this->postResource->load($post, $id));
                $this->messageManager->addSuccessMessage(__('You deleted the post.'));
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['post_id' => $id]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('We can\'t delete the post.'));
                return $resultRedirect->setPath('*/*/edit', ['post_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a post to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}