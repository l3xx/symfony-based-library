<?php
/**
 * Created by PhpStorm.
 * User: letunovskiymn
 * Date: 27.04.16
 * Time: 20:57
 */

namespace AppBundle\Twig\Extension;


use Symfony\Component\DependencyInjection\ContainerInterface;

class ImgExtension extends \Twig_Extension
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('imageResize', array($this, 'imageResize')),
        );
    }

    /**
     * @param $path
     * @param $w
     * @param $h
     * @return string
     */
    public function imageResize($path,$w=200,$h=200)
    {
        $helper=$this->container->get('helper.path');
        $simpleImage=$this->container->get('helper.simple_image');
        $realPath=$helper->getWebPath().DIRECTORY_SEPARATOR.$path;
        $simpleImage->load($realPath);
        $simpleImage->resize($w, $h);
        $newPath=$helper->getCacheDir().DIRECTORY_SEPARATOR.md5($path).'.jpg';
        $simpleImage->save($helper->getWebPath().DIRECTORY_SEPARATOR.$newPath);
        return $newPath;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'imageResize';
    }
}