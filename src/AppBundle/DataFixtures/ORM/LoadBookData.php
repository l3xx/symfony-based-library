<?php
/**
 * Created by PhpStorm.
 * User: letunovskiymn
 * Date: 27.04.16
 * Time: 2:19
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Book;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadBookData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $book = new Book();
        $book->setAuthor('Борис Васильев');
        $book->setName('А зори здесь тихие…');
        $book->setIsDownloaded(true);
        $manager->persist($book);

        $book = new Book();
        $book->setAuthor('Борис Полевой');
        $book->setName('Повесть о настоящем человеке');
        $book->setIsDownloaded(true);
        $manager->persist($book);

        $book = new Book();
        $book->setAuthor('Борис Васильев');
        $book->setName('В списках не значился');
        $book->setIsDownloaded(true);
        $manager->persist($book);

        $book = new Book();
        $book->setAuthor('Василь Быков');
        $book->setName('Сотников');
        $book->setIsDownloaded(true);
        $manager->persist($book);

        $manager->flush();
    }
}