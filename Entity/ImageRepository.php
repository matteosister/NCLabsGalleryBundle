<?php
namespace NCLabs\Bundle\GalleryBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ImageRepository extends EntityRepository
{
    public function getImageById($imageId)
    {
        try
        {
            return $this->_em->createQuery("SELECT i
                                            FROM NCLabsGalleryBundle:Image i
                                            WHERE i.imageId = :image_id")
                             ->setParameter('image_id', $imageId)
                             ->getSingleResult();
        }
        catch (NoResultException $e)
        {
            return array();
        }
    }
}