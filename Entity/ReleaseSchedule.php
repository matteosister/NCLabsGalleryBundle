<?php

namespace NCLabs\Bundle\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NCLabs\Bundle\GalleryBundle\Entity\ReleaseSchedule
 *
 * @ORM\Table(name="release_schedule")
 * @ORM\Entity
 */
class ReleaseSchedule
{
    /**
     * @var integer $releaseId
     *
     * @ORM\Column(name="release_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $releaseId;

    /**
     * @var integer $galleryId
     *
     * @ORM\Column(name="gallery_id", type="integer", nullable=false)
     */
    private $galleryId;

    /**
     * @var integer $releaseTime
     *
     * @ORM\Column(name="release_time", type="datetime", nullable=false)
     */
    private $releaseTime;



    /**
     * Get releaseId
     *
     * @return integer $releaseId
     */
    public function getReleaseId()
    {
        return $this->releaseId;
    }

    /**
     * Set galleryId
     *
     * @param integer $galleryId
     */
    public function setGalleryId($galleryId)
    {
        $this->galleryId = $galleryId;
    }

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
     * Set releaseTime
     *
     * @param DateTime $releaseTime
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
}