<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api/v1")
 *
 */
class ApiController extends FOSRestController
{
    /**
     * @Route("/", name="api_index",defaults={"_format":"json"} )
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $serializer = $this->container->get('jms_serializer');
        $view = $this->view(array(), 200)
//            ->setTemplate("MyBundle:Category:show.html.twig")
//            ->setTemplateVar('products')
//            ->setTemplateData($templateData)
        ;
        return $this->handleView($view);
    }
}
