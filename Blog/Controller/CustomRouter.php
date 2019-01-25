<?php
namespace Vitvik\Blog\Controller;

use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\DataObject;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\State;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Url;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;


/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CustomRouter implements \Magento\Framework\App\RouterInterface
{
    /**
     * @var bool
     */
    protected $dispatched;

    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;

    /**
     * Page factory
     *
     * @var \Magento\Cms\Model\PageFactory
     */
    protected $_pageFactory;

    /**
     * Url
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $_url;

    /**
     * Response
     *
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $_response;

    /**
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Magento\Framework\UrlInterface $url
     * @param \Magento\Cms\Model\PageFactory $pageFactory
     * @param \Magento\Framework\App\ResponseInterface $response
     */
    public function __construct(
        ActionFactory $actionFactory,
        UrlInterface $url,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Framework\App\ResponseInterface $response
    ) {
        $this->actionFactory = $actionFactory;
        $this->_url = $url;
        $this->_pageFactory = $pageFactory;
        $this->_response = $response;
    }

    /**
     * Validate and Match Blog Page and modify request
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return \Magento\Framework\App\ActionInterface|null
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        if (!$this->dispatched) {

        $identifier = trim($request->getPathInfo(), '/');

        if(strpos($identifier, 'post') !== false) {

            $url = explode("/", $identifier);
            $postId = array_pop($url);

            if(isset($postId) && is_numeric($postId)) {
                $request->setModuleName('blog')->setControllerName('index')->setActionName('post')->setParams(['post_id' => $postId]);
            }
            else{
                    $request->setModuleName('cms')->setControllerName('noroute')->setActionName('index');
                }
            }

            $request->setAlias(Url::REWRITE_REQUEST_PATH_ALIAS, $identifier);

            $request->setDispatched(true);
            $this->dispatched = true;

            return $this->actionFactory->create(
                'Magento\Framework\App\Action\Forward',
                ['request' => $request]
            );
        }
        return null;
    }
}
