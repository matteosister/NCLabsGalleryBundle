<?php
namespace NCLabs\Bundle\GalleryBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ImageController extends ContainerAware
{
    private $rootDir;

    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    public function viewAction($quality, $galleryID, $imageName)
    {
        $security = $this->container->get('security.context');
        $image    = $this->getRepository('Gallery')->getGalleryImage($galleryID, \basename($imageName, '.JPG'));
        $gallery  = $image->getGallery();

        if (!$gallery->getReleaseTime())
        {
            $quality = 'preview';
        }
        
        if ($gallery->isProtected() && !$security->isGranted('ROLE_MEMBER'))
        {
            throw new AccessDeniedException();
        }

        $filename = ($quality == 'thumb' ? 'th_' : '') . $imageName;
        $imagePath = $this->rootDir . '/' . \sprintf('%04s', $galleryID) . '/' . ($quality == 'thumb' ? 'thumbnails' : $quality) . '/' . $filename;

        if (!file_exists($imagePath))
        {
            throw new NotFoundHttpException("Unable to find image with name '$imagePath'. Have you verified that the path is correct?");
        }

        \ob_start();
        @readfile($imagePath);
        $content = \ob_get_contents();
        \ob_end_clean();

        $headers = array('Content-Type'        => 'image/jpeg',
                         'Cache-Control'       => 'private',
                         'Content-Disposition' => 'inline; filename="' . $filename . '"');

        return new Response($content, 200, $headers);
    }
    
    private function getRepository($name)
    {
        $repository = 'NCLabs\\Bundle\\GalleryBundle\\Entity\\' . $name;
        return $this->container
                    ->get('doctrine')
                    ->getEntityManager()
                    ->getRepository($repository);
    }
}