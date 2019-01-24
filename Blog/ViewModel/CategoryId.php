<?php
namespace Vitvik\Blog\ViewModel;
class CategoryId implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    protected $registry;
    public function __construct(
        \Magento\Framework\Registry $registry
    ) {
        $this->registry = $registry;
    }
    public function getCurrentCategoryId()
    {
        return $this->registry->registry('current_category')->getId();
    }
}