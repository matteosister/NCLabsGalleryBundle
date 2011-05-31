<?php

namespace NCLabs\Bundle\GalleryBundle\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;

use NCLabs\Bundle\GalleryBundle\Model\GalleryManagerInterface;

class GalleryManager implements GalleryManagerInterface
{
    private $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getNextUpdate()
    {
        
    }
    
    public function getImages($galleryId, $limit, $offset)
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
    
    public function findGalleryById($galleryId)
    {
        $gallery = $this->getRepository('Gallery')->findBy(array(
            'galleryId'      => $galleryId,
            'galleryEnabled' => 1
        ));
        
        return $gallery;
    }
    
    public function countImages($galleryId)
    {
        return $this->getRepository('Gallery')->countImages($galleryId);
    }
    
    /**
     *
     * @param string $class
     * @return EntityRepository
     */
    public function getRepository($class)
    {
        return $this->container
                    ->get('doctrine')->getEntityManager()
                    ->getRepository('NCLabs\\Bundle\\GalleryBundle\\Entity\\' . $class);
    }
}