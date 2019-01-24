<?php
namespace Vitvik\Blog\Block\Adminhtml\Blog\Edit;
use Magento\Backend\Block\Widget\Context;
/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;
    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }
    /**
     * Return post ID
     *
     * @return int|null
     */
    public function getPostId()
    {
        return (int)$this->context->getRequest()->getParam('post_id');
    }
    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}