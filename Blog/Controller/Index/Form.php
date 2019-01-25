<?php
namespace Vitvik\Blog\Controller\Index;

class Form extends \Magento\Framework\App\Action\Action
{
    protected $pageResultFactory;
    private $customerSession;
    private $redirect;

    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageResultFactory,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory

    ) {
        $this->pageResultFactory = $pageResultFactory;
        $this->customerSession = $customerSession;
        $this->redirect = $resultRedirectFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        if(!$this->customerSession->isLoggedIn()) {
            $this->messageManager->addError( __('Sorry but only registered user can write a post.') );
            $result = $this->redirect->create();
            return  $result->setPath('customer/account/login');
        }
        $result = $this->pageResultFactory->create();
        return $result;
    }


}