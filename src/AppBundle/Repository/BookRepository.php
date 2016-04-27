<?php

namespace AppBundle\Repository;


/**
 * BookRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BookRepository extends BaseRepository
{
    public function getAll($liveTime=86400)
    {
        $q=$this->createQueryBuilder('b');
        $q->select('b');
        $query = $q->getQuery();
        $query->useResultCache(true, $liveTime, 'book_cache');
        return $query->getResult();
    }
}
