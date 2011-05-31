<?php
namespace NCLabs\Bundle\GalleryBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

class GalleryController extends ContainerAware
{
    private $title = 'View Gallery';
    private $type = 'shadowbox';
    private $imgPerRow = 4;
    private $imgPerPage = 28;
    private $template = 'NCLabsGalleryBundle:Gallery:gallery.html.twig';
    private $quality = 'lowres';

    public function viewAction($quality, $galleryID, $page = 1)
    {
        $this->quality = $quality;
        
        $this->container->get('session')->set('gallery_quality', $this->quality);
        
        if ($page < 1)
        {
            $page = 1;
        }

        $imgPerPage = $this->getImgPerPage();
        $offset = $page * $imgPerPage - $imgPerPage;

        $gallery = $this->getRepository('Gallery')
                        ->getGalleryImages($galleryID, $imgPerPage, $offset);

        if (!$gallery)
        {
            throw new NotFoundHttpException("Unable to find the specified gallery with id '$galleryID'");
        }

        $protected = $gallery[0]->getGallery()->isProtected();
        $released  = $gallery[0]->getGallery()->getReleaseTime();
        
        if (!$released)
        {
            throw new AccessDeniedException();
        }
        
        $security = $this->container->get('security.context');

        if ($protected && !$security->isGranted('ROLE_MEMBER'))
        {
            throw new AccessDeniedException();
        }

        return $this->container->get('templating')->renderResponse($this->template, array(
            'title'      => $this->getTitle(),
            'type'       => $this->getType(),
            'imgPerRow'  => $this->getImgPerRow(),
            'route'      => $protected ? 'members_view_image' : 'image_view',
            'quality'    => $this->getQuality(),
            'gallery'    => $gallery,
            'galleryID'  => $galleryID,
            'page'       => $page
        ));
    }

    public function comingSoonAction()
    {
        $next = $this->getRepository('ReleaseSchedule')
                     ->getNextUpdate();

        if (!$next)
        {
            throw new RuntimeException('No new updates scheduled! Someone has been slacking...', 500);
        }

        $gallery = $this->getRepository('Gallery')
                        ->getGallery($next->getGalleryId());
        $images = explode(';', $gallery->getPreview());

        return $this->container->get('templating')->renderResponse('NCLabsGalleryBundle:Gallery:coming_soon.html.twig', array(
            'next'    => $next,
            'gallery' => $gallery,
            'images'  => $images
        ));
    }

    public function recentUpdatesAction($quality, $limit = 20)
    {
        $previews = array();
        $previous = $this->getRepository('Gallery')
                         ->getRecentGalleries($limit);

        if (!$previous)
        {
            throw new RuntimeException('No previous updates found! You better have the database backed up...', 500);
        }

        foreach ($previous as $update)
        {
            $previews[$update->getGalleryId()] = explode(';', $update->getPreview());
        }

        return $this->container->get('templating')->renderResponse('NCLabsGalleryBundle:Gallery:recent_updates.html.twig', array(
            'quality'  => $quality,
            'previews' => $previews,
            'previous' => $previous
        ));
    }

    public function nextUpdateAction()
    {
        $next = $this->getRepository('ReleaseSchedule')
                     ->getNextUpdate();

        return $this->container->get('templating')->renderResponse('NCLabsGalleryBundle:Gallery:next.html.twig', array(
            'next'    => $next
        ));
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = (string)$title;
    }
    
    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = (string)$type;
    }

    public function getImgPerRow()
    {
        return $this->imgPerRow;
    }

    public function setImgPerRow($imgPerRow)
    {
        $this->imgPerRow = (int)$imgPerRow;
    }

    public function getImgPerPage()
    {
        return $this->imgPerPage;
    }

    public function setImgPerPage($imgPerPage)
    {
        $this->imgPerPage = (int)$imgPerPage;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate($template)
    {
        $this->template = (string)$template;
    }

    public function getQuality()
    {
        return $this->quality;
    }

    public function setQualitly($quality)
    {
        $this->quality = (string)$quality;
    }

    /**
     *
     * @param string $class
     * @return EntityRepository
     */
    public function getRepository($class)
    {
        return $this->container
                    ->get('doctrine')
                    ->getEntityManager()
                    ->getRepository('NCLabs\\Bundle\\GalleryBundle\\Entity\\' . $class);
    }
}
