<?php
/**
 * Created by PhpStorm.
 * User: letunovskiymn
 * Date: 27.04.16
 * Time: 1:08
 */

namespace AppBundle\Security;


use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class ApiKeyUserProvider implements UserProviderInterface
{

    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * Constructor.
     *
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function getUsernameForApiKey($apiKey)
    {
        /** @var UserInterface $user */
        $user=$this->userManager->findUserBy(array('token'=>$apiKey));
        if (!$user){
            return;
        }
        $username = $user->getUsername();

        return $username;
    }

    public function loadUserByUsername($username)
    {
        return $this->userManager->findUserByUsername($username);
    }

    public function refreshUser(UserInterface $user)
    {
        // this is used for storing authentication in the session
        // but in this example, the token is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        $userClass = $this->userManager->getClass();

        return $userClass === $class || is_subclass_of($class, $userClass);
    }

}

