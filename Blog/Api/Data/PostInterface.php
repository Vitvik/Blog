<?php
namespace Vitvik\Blog\Api\Data;

interface PostInterface
{
    /**#@+
     * Constants
     * @var string
     */
    const POST_ID = 'post_id';
    const TITLE = 'title';
    const CONTENT = 'content';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';
    const IS_ACTIVE = 'is_active';

    /**#@-*/

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     * @return PostInterface
     */
    public function setTitle(string $title);

    /**
     * @return string
     */
    public function getContent();

    /**
     * @param string $content
     * @return PostInterface
     */
    public function setContent(string $content);

    /**
     * @return string
     */
    public function getCreationTime();

    /**
     * @param string $createdTime
     * @return $this
     */
    public function setCreatedTime(string $createdTime);

    /**
     * @return string
     */
    public function getUpdateTime();

    /**
     * @param string $updatedTime
     * @return $this
     */
    public function setUpdatedTime(string $updatedTime);

    /**
     * @return int
     */
    public function getIsActive();

    /**
     * @param int $isActive
     * @return $this
     */
    public function setIsActive($isActive);
}
