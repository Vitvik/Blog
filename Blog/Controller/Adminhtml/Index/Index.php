<?php
namespace Vitvik\Blog\Controller\Adminhtml\Index;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use \Magento\Backend\App\Action;
class Index extends  Action
{
    const ADMIN_RESOURCE = 'Vitvik_Blog::blog';
    protected $resultPageFactory;
    protected $dataPersistor;
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        DataPersistorInterface $dataPersistor
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Blog'));
//        $this->initPage($resultPage)->getConfig()->getTitle()->prepend(__('Blog'));
//        $this->dataPersistor->clear('blog');
        return $resultPage;
    }
}