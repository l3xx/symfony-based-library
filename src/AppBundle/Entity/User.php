<?php
/**
 * Created by PhpStorm.
 * User: letunovskiymn
 * Date: 26.04.16
 * Time: 20:28
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * API Токен
     *
     * @var string
     *
     * @ORM\Column(name="token", type="string", nullable=true, options={"comment": "API Токен"})
     */
    private $token;


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }
}