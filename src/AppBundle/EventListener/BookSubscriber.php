<?php
/**
 * Created by PhpStorm.
 * User: letunovskiymn
 * Date: 27.04.16
 * Time: 19:47
 */

namespace AppBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Book;
use Symfony\Component\DependencyInjection\ContainerInterface;


class BookSubscriber  implements EventSubscriber
{

    private $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'postDelete',
        );
    }
    public function preDelete(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function index(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();
        $helper=$this->container->get('helper.path');

            // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Book) {
            if ($entity->getFileBook())
            {
                $helper->deleteFile($entity->getFileBook());
            }

            if ($entity->getCover())
            {
                $helper->deleteFile($entity->getCover());
            }
        }
    }

}