<?php

namespace NCLabs\Bundle\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use NCLabs\Bundle\GalleryBundle\Model\Gallery as BaseGallery;

/**
 * NCLabs\Bundle\GalleryBundle\Entity\Gallery
 *
 * @ORM\Table(name="gallery")
 * @ORM\Entity
 */
class Gallery extends BaseGallery
{
    /**
     * @var integer $galleryId
     */
    private $galleryId;

    /**
     * @var boolean $protected
     */
    private $protected;

    /**
     * @var boolean $enabled
     */
    private $enabled;

    /**
     * @var DateTime $releaseTime
     */
    private $releaseTime;

    /**
     * @var text $blog
     */
    private $blog;

    /**
     * @var string $preview
     */
    private $preview;


    /**
     * Get galleryId
     *
     * @return integer $galleryId
     */
    public function getGalleryId()
    {
        return $this->galleryId;
    }

    /**
     * Get galleryId
     *
     * @return boolean $galleryId
     */
    public function setGalleryId($galleryId)
    {
        $this->galleryId = $galleryId;
    }

    /**
     * Set protected
     *
     * @param boolean $protected
     */
    public function setProtected($protected)
    {
        $this->protected = $protected;
    }

    /**
     * Get protected
     *
     * @return boolean $protected
     */
    public function isProtected()
    {
        return $this->protected;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Get enabled
     *
     * @return boolean $enabled
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set releaseTime
     *
     * @param integer $releaseTime
     */
    public function setReleaseTime(\DateTime $releaseTime)
    {
        $this->releaseTime = $releaseTime;
    }

    /**
     * Get releaseTime
     *
     * @return DateTime $releaseTime
     */
    public function getReleaseTime()
    {
        return $this->releaseTime;
    }

    /**
     * Set blog
     *
     * @param text $blog
     */
    public function setBlog($blog)
    {
        $this->blog = $blog;
    }

    /**
     * Get blog
     *
     * @return text $blog
     */
    public function getBlog()
    {
        return $this->blog;
    }

    /**
     * Set preview
     *
     * @param string $preview
     */
    public function setPreview($preview)
    {
        $this->preview = $preview;
    }

    /**
     * Get preview
     *
     * @return string $preview
     */
    public function getPreview()
    {
        return $this->preview;
    }
}