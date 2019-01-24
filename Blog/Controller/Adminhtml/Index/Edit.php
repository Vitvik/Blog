<?php
namespace Vitvik\Blog\Controller\Adminhtml\Index;
use Magento\Framework\Exception\NoSuchEntityException;
use \Magento\Backend\App\Action;
class Edit extends Action
{
    const ADMIN_RESOURCE = 'Vitvik_Blog::post_save';
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;
    private $postResource;
    private $blogFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Vitvik\Blog\Model\BlogFactory $blogFactory,
        \Vitvik\Blog\Model\ResourceModel\Blog $postResource
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->postResource = $postResource;
        $this->blogFactory = $blogFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('post_id');
        $model = $this->blogFactory->create();

//         2. Initial checking VIA RESOURCE MODEL
        if ($id) {
            $this->postResource->load($model, $id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This post no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
//        $this->initPage($resultPage)->addBreadcrumb(
//            $id ? __('Edit post') : __('New post'),
//            $id ? __('Edit post') : __('New post')
//        );
        $resultPage->getConfig()->getTitle()->prepend(__('Post'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New Post'));
        return $resultPage;
    }
}