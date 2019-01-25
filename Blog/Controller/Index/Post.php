<?php
namespace Vitvik\Blog\Controller\Index;


class Post extends \Magento\Framework\App\Action\Action
{
    protected $pageResultFactory;
    protected $request;
    protected $registry;


    public function __construct(
    \Magento\Framework\View\Result\PageFactory $pageResultFactory,
    \Magento\Framework\App\Action\Context $context,
    \Magento\Framework\App\RequestInterface  $request,
    \Magento\Framework\Registry $registry

) {
    $this->request = $request;
    $this->pageResultFactory = $pageResultFactory;
    $this->registry = $registry;

    parent::__construct($context);
}
    public function execute()
{
//    $url = explode("/", $this->request->getPathInfo());
//    $id = array_pop($url);
    $id = $this->request->getParam('post_id');
    $this->registry->register('POST_ID', $id);
    $result = $this->pageResultFactory->create();
    return $result;
}
}