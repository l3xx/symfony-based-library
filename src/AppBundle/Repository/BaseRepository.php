<?php

namespace AppBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use FOS\UserBundle\Model\User;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM as ORM;

/**
 * BaseRepository
 *
 */
class BaseRepository extends \Doctrine\ORM\EntityRepository
{
    /** @var Container */
    private $container;

    private $currentUser;

    public function __construct($em, $class)
    {
        parent::__construct($em, $class); // TODO: Change the autogenerated stub
    }

    /**
     * Внедряем все зависимости из контейнера
     */
    public function setContainer($container)
    {
        $this->container = $container;
        return $this;
    }

    public function getContainer()
    {
        return $this->container;
    }

    /** Событие до вставки сущности */
    protected function prePersist($entity) {}
    /** Событие после вставки сущности */
    protected function postPersist($entity) {}

    /** Событие до обновления сущности */
    protected function preUpdate($entity) {}

    protected function getEnvironment()
    {
        return $this->container ? $this->container->getParameter('kernel.environment') : null;
    }

    /**
     * Сохранение сущности
     * @param $entity
     * @param null $cacheName
     * @throws ORM\ORMException
     */
    public function save($entity,$cacheName=null)
    {
        try {
            $em = $this->getEntityManager();
            $isNew = is_null($entity->getId());

            if ($isNew) {
                $this->prePersist($entity);
                $em->persist($entity);
            } else {
                $this->preUpdate($entity);
            }
            $em->flush();
            if ($isNew) {
                $this->postPersist($entity);
            }

            if ($cacheName)
            {
                $cacheDriver = $this->getEntityManager()->getConfiguration()->getResultCacheImpl();
                $cacheDriver->delete($cacheName);
            }
        } catch (\Exception $e) {
            throw new ORM\ORMException('Не удается сохранить объект ' . get_class($entity), 0, $e);
        }
    }

    /**
     * Удаление сущности
     * @param $entity
     * @throws \Doctrine\ORM\ORMException
     */
    public function remove($entity)
    {
        try {
            $em = $this->getEntityManager();
            $em->remove($entity);
            $em->flush();
        } catch (\Exception $e) {
            throw new ORM\ORMException('Не удается удалить объект ' . get_class($entity), 0, $e);
        }
    }

    /**
     *
     */
    public function clear()
    {
        $this->getEntityManager()->clear();
    }


    /**
     * @return User
     */
    public function getCurrentUser()
    {
        if ($token = $this->container->get('security.token_storage')->getToken()) {
            if ($token->getUser() instanceof User) {
                return $token->getUser();
            }
        }
        return;
    }

    /**
     * @param User $currentUser
     */
    public function setCurrentUser($currentUser)
    {
        $this->currentUser = $currentUser;
    }


    /**
     * Удаление по id
     * @param array $ids
     * @return array
     */
    public function delete($ids)
    {
        /* @var $query QueryBuilder  */
        $query = $this->createQueryBuilder('q');
        $query
            ->delete()
            ->andWhere('q.id in (:ids)')->setParameter('ids', $ids);
        return $query->getQuery()->getResult();
    }

}
