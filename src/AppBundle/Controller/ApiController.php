<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Form\BookFormApiType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api/v1")
 *
 */
class ApiController extends FOSRestController
{
    /**
     * @Route("/books", name="api_index",defaults={"_format":"json"} )
     * @Security("has_role('ROLE_API')")
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $bookRepository=$this->getDoctrine()->getRepository('AppBundle:Book');
        $books=$bookRepository->getAll();
        $newBooks=array();
        /** @var Book $book */
        foreach ($books as $key=> $book)
        {
            if ($book->getIsDownloaded()==false)
            {
                $book->setFileBook(null);
            }
            $newBooks[$key]=$book;
        }
        $view = $this->view($newBooks, 200);
        return $this->handleView($view);
    }



    /**
     * Обновление данных о книге<br/>
     * @Route("/books/{id}/edit", name="api_edit",defaults={"_format":"json"} )
     * @Security("has_role('ROLE_API')")
     * @Method("POST")
     *
     * @RequestParam(name="name", nullable=false, strict=true, description="Name book.")
     * @RequestParam(name="author", nullable=false, strict=true, description="Author Book.")
     */
    public function editAction(Request $request)
    {

        $bookRepository=$this->getDoctrine()->getRepository('AppBundle:Book');
        $id = (int)$request->get('id');
        $book=$bookRepository->find($id);
        if (!$book)
        {
            throw $this->createNotFoundException('The product does not exist');
        }

        $book->setName($request->get('name'));
        $book->setAuthor($request->get('author'));

        $errors = $this->get('validator')->validate($book);
        if (count($errors) == 0) {
            $bookRepository->save($book);
            $view =$this->view($book,200);
        } else {
            $view = $this->view($errors, 400);

        }
          return $this->handleView($view);
    }

    /**
     * Обновление данных о книге<br/>
     * @Route("/books/add", name="api_add",defaults={"_format":"json"} )
     * @Security("has_role('ROLE_API')")
     * @Method("GET|POST")
     *
     * @RequestParam(name="name", nullable=false, strict=true, description="Name book.")
     * @RequestParam(name="author", nullable=false, strict=true, description="Author Book.")
     */
    public function addAction(Request $request)
    {

        $bookRepository=$this->getDoctrine()->getRepository('AppBundle:Book');
        $book=new Book();
        $book->setName($request->get('name'));
        $book->setAuthor($request->get('author'));

        $errors = $this->get('validator')->validate($book);
        if (count($errors) == 0) {
            $bookRepository->save($book);
            $view =$this->view($book,201);
        } else {
            $view = $this->view($errors, 400);

        }
        return $this->handleView($view);
    }

}
