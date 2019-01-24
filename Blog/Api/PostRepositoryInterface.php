<?php
namespace Vitvik\Blog\Api;

use Vitvik\Blog\Api\Data\PostInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface PostRepositoryInterface
 * @package Vitvik\Api
 * @api
 */
interface PostRepositoryInterface
{
    /**
     * @param int $id
     * @return \Vitvik\Blog\Api\Data\PostInterface
     */
    public function getById($id);


    /**
     * @param int $id
     * @return \Vitvik\Blog\Api\Data\PostInterface
     */
    public function getTitleByCatId($id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Vitvik\Blog\Api\Data\PostSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param \Vitvik\Blog\Api\Data\PostInterface $post
     * @return \Vitvik\Blog\Api\Data\PostInterface
     */
    public function save(PostInterface $post);

    /**
     * @param \Vitvik\Blog\Api\Data\PostInterface $post
     * @return bool
     */
    public function delete(PostInterface $post);

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id);
}