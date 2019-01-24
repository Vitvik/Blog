<?php
namespace Vitvik\Blog\Model;

class Blog extends \Magento\Framework\Model\AbstractModel implements \Vitvik\Blog\Api\Data\PostInterface
{
    const POST_PATH = '/blog/index/post/';
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    private $urlBuilder;

    protected function _construct()
    {
        $this->_init(\Vitvik\Blog\Model\ResourceModel\Blog::class);
    }

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        \Magento\Framework\UrlInterface $urlInterface,
        array $data = [])
    {
        $this->urlBuilder = $urlInterface;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve url to post view
     *
     * @return string
     */
    public function appendUrl(){
       return $this->setData('url', $this->urlBuilder->getUrl(self::POST_PATH .$this->getId()));
    }

    /**
     * Retrieve post id
     *
     * @return int
     */
    public function getId(){
        return $this->getData(self::POST_ID);
    }

    /**
     * Retrieve post title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Retrieve post content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Retrieve post creation time
     *
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Retrieve post update time
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Is active
     *
     * @return bool
     */
    public function getIsActive()
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return PostInterface
     */
    public function setId($id)
    {
        return $this->setData(self::POST_ID, $id);
    }


    /**
     * Set title
     *
     * @param string $title
     * @return PostInterface
     */
    public function setTitle(string $title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return PostInterface
     */
    public function setContent(string $content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return PostInterface
     */
    public function setCreatedTime(string $createdTime)
    {
        return $this->setData(self::CREATION_TIME, $createdTime);
    }

    /**
     * Set update time
     *
     * @param string $updatedTime
     * @return PostInterface
     */
    public function setUpdatedTime(string $updatedTime)
    {
        return $this->setData(self::UPDATE_TIME, $updatedTime);
    }

    /**
     * Set is active
     *
     * @param bool|int $isActive
     * @return PostInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

}