<?php
namespace Vitvik\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface PostSearchResultInterface
 * @package AlexPoletaev\Blog\Api\Data
 */
interface PostSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Vitvik\Blog\Api\Data\PostInterface[]
     */
    public function getItems();

    /**
     * @param \Vitvik\Blog\Api\Data\PostInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
