<?php

namespace NCLabs\Bundle\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NCLabs\Bundle\GalleryBundle\Entity\Image
 * 
 * @ORM\Table(name="image")
 * @ORM\Entity
 */
class Image
{
    /**
     * @var integer $imageId
     */
    private $imageId;

    /**
     * @var string $imageName
     */
    private $imageName;

    /**
     * @var string $imageCaption
     */
    private $imageCaption;

    /**
     * @var NCLabs\Bundle\GalleryBundle\Entity\Gallery
     */
    private $gallery;


    /**
     * Get imageId
     *
     * @return integer $imageId
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    /**
     * Get imageName
     *
     * @return string $imageName
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set imageCaption
     *
     * @param string $imageCaption
     */
    public function setImageCaption($imageCaption)
    {
        $this->imageCaption = $imageCaption;
    }

    /**
     * Get imageCaption
     *
     * @return string $imageCaption
     */
    public function getImageCaption()
    {
        return $this->imageCaption;
    }

    /**
     * Set gallery
     *
     * @param NCLabs\Bundle\GalleryBundle\Entity\Gallery $gallery
     */
    public function setGallery(\NCLabs\Bundle\GalleryBundle\Entity\Gallery $gallery)
    {
        $this->gallery = $gallery;
    }

    /**
     * Get gallery
     *
     * @return NCLabs\Bundle\GalleryBundle\Entity\Gallery $gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }
}