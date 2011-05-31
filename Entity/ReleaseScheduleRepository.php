<?php
namespace NCLabs\Bundle\GalleryBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ReleaseScheduleRepository extends EntityRepository
{
    public function getNextUpdate()
    {
        try
        {
            return $this->_em->createQuery("SELECT r
                                            FROM NCLabsGalleryBundle:ReleaseSchedule r
                                            WHERE r.releaseTime = (SELECT MIN(s.releaseTime)
                                                                   FROM NCLabsGalleryBundle:ReleaseSchedule s)")
                             ->getSingleResult();
        }
        catch (NoResultException $e)
        {
            return array();
        }
    }
}