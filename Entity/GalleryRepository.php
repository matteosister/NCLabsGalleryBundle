<?php
namespace NCLabs\Bundle\GalleryBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class GalleryRepository extends EntityRepository
{
    /**
     *
     * @param integer $galleryId
     * @return array
     */
    public function getGallery($galleryId)
    {
        try
        {
            return $this->_em->createQuery("SELECT g
                                            FROM NCLabsGalleryBundle:Gallery g
                                            WHERE g.galleryId = :gallery_id AND
                                                  g.enabled = 1")
                             ->setParameter('gallery_id', $galleryId)
                             ->getSingleResult();
        }
        catch (NoResultException $e)
        {
            return array();
        }
    }

    /**
     *
     * @param integer $limit
     * @return array
     */
    public function getRecentGalleries($limit)
    {
        try
        {
            return $this->_em->createQuery("SELECT g
                                            FROM NCLabsGalleryBundle:Gallery g
                                            WHERE g.releaseTime > '1970-01-01 00:00:00'
                                            ORDER BY g.releaseTime DESC")
                             ->setMaxResults($limit)
                             ->getResult();
        }
        catch (NoResultException $e)
        {
            return array();
        }
    }

    public function getGalleryImage($galleryId, $imageName)
    {
        try
        {
            return $this->_em->createQuery("SELECT i, g
                                            FROM NCLabsGalleryBundle:Image i
                                            JOIN i.gallery g
                                            WHERE g.galleryId = :gallery_id AND
                                                  i.imageName = :image_name")
                        ->setParameters(array('gallery_id' => $galleryId,
                                              'image_name' => $imageName))
                        ->getSingleResult();
        }
        catch (NoResultException $e)
        {
            return array();
        }
    }

    /**
     *
     * @param integer $galleryId
     * @param integer $limit
     * @param integer $offset
     * @return array
     */
    public function getGalleryImages($galleryId, $limit = 28, $offset = 0)
    {
        try
        {
            return $this->_em->createQuery("SELECT i, g
                                            FROM NCLabsGalleryBundle:Image i
                                            JOIN i.gallery g
                                            WHERE g.galleryId = :gallery_id
                                            ORDER BY i.imageName ASC")
                        ->setParameter('gallery_id', $galleryId)
                        ->setMaxResults($limit)
                        ->setFirstResult($offset)
                        ->getResult();
        }
        catch (NoResultException $e)
        {
            return array();
        }
    }

    public function countImages($galleryId)
    {
        try
        {
            $count = $this->_em->createQuery("SELECT COUNT(i.imageId)
                                              FROM NCLabsGalleryBundle:Image i
                                              JOIN i.gallery g
                                              WHERE g.galleryId = :gallery_id")
                          ->setParameter('gallery_id', $galleryId)
                          ->getResult();

            return $count[0][1];
        }
        catch (NoResultException $e)
        {
            return false;
        }
    }

    /**
     *
     * @param int $galleryId
     * @return bool
     */
    public function isReleased($galleryId)
    {
        try
        {
            $gallery = $this->_em->createQuery("SELECT g
                                                FROM NCLabsGalleryBundle:Gallery g
                                                WHERE g.galleryId = :gallery_id")
                            ->setParameter('gallery_id', $galleryId)
                            ->getSingleResult();

            return (bool)($gallery->getReleaseTime() > '1970-01-01 00:00:00');
        }
        catch (NoResultException $e)
        {
            return false;
        }
    }
}