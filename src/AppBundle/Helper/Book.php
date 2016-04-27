<?php
/**
 * Created by PhpStorm.
 * User: letunovskiymn
 * Date: 27.04.16
 * Time: 18:34
 */

namespace AppBundle\Helper;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Book
{
    private $container;
    private $fs;
    private $levels=16;
    private $imgDir="books";
    private $cacheDir="cache";


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->fs = new Filesystem();
    }

    public function moveFile(UploadedFile $file)
    {
        $name=md5($file->getClientOriginalName());
        $path=$this->getWebPath().DIRECTORY_SEPARATOR.$this->getImgDir();
        $namePath = str_split($name, $this->levels);
        $pathAdded='';
        foreach ($namePath as $pathAdd)
        {
            $pathAdded.=DIRECTORY_SEPARATOR.$pathAdd;
        }
        $this->fs->mkdir($path);
        $q=uniqid();
        $file->move($path.$pathAdded.DIRECTORY_SEPARATOR,$q.$file->getClientOriginalName());
        return $this->imgDir.$pathAdded.DIRECTORY_SEPARATOR.$q.$file->getClientOriginalName();
    }

    public function deleteFile($filePath)
    {
        $name=$this->getWebPath().DIRECTORY_SEPARATOR.$filePath;
        unlink($name);
        return ;
    }


    /**
     * @return string
     */
    public function getWebPath()
    {
        $kernel=$this->container->get('kernel');
        return $kernel->getRootDir().DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."web";
    }

    public function getImgPath()
    {
        $path=$this->getWebPath().DIRECTORY_SEPARATOR.$this->getImgDir();
        if (!$this->fs->exists($path)) throw new \Exception('Img directory not found');
        return $path;
    }

    /**
     * @return string
     */
    public function getImgDir()
    {
        return $this->imgDir;
    }

    /**
     * @param string $imgDir
     */
    public function setImgDir($imgDir)
    {
        $this->imgDir = $imgDir;
    }

    /**
     * @return Filesystem
     */
    public function getFs()
    {
        return $this->fs;
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return $this->cacheDir;
    }

    /**
     * @param string $cacheDir
     */
    public function setCacheDir($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }
}