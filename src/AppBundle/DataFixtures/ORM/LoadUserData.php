<?php
/**
 * Created by PhpStorm.
 * User: letunovskiymn
 * Date: 27.04.16
 * Time: 2:19
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setPlainPassword('admin');
        $user->setEnabled('true');
        $user->setEmail('admin@example.com');
        $user->setToken(md5(rand(0,1000).time()));
        $user->setRoles(array('ROLE_ADMIN','ROLE_API'));
        $manager->persist($user);



        $user = new User();
        $user->setUsername('notadmin');
        $user->setPlainPassword('notadmin');
        $user->setEnabled('true');
        $user->setEmail('notadmin@example.com');
        $user->setToken(md5(rand(0,1000).time()));
        $manager->persist($user);

        $manager->flush();
    }
}