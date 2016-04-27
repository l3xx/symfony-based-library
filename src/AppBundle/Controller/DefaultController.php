<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Form\BookFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template("AppBundle:Default:index.html.twig")
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $bookRepository=$this->getDoctrine()->getRepository('AppBundle:Book');
        $books=$bookRepository->getAll();
        return array('books'=>$books);
    }

    /**
     * @Route("/read/{id}", name="read_book", requirements={"id": "\d+"})
     * @Template("AppBundle:Default:read.html.twig")
     * @param Request $request
     * @return array
     */
    public function readAction(Request $request)
    {
        $id = (int)$request->get('id');
        $bookRepository=$this->getDoctrine()->getRepository('AppBundle:Book');
        $book=$bookRepository->find($id);
        return array('book'=>$book);
    }


    /**
     * @Route("/edit/{id}", name="edit_book", requirements={"id": "\d+"})
     * @Template("AppBundle:Default:edit.html.twig")
     * @param Request $request
     * @return array
     */
    public function editAction(Request $request)
    {
        $id = (int)$request->get('id');
        $bookRepository=$this->getDoctrine()->getRepository('AppBundle:Book');
        if ($id===0)
        {
            //добавление
            $book=new Book();
        }
        else
        {
            //редактирвоание
            $book=$bookRepository->find($id);
        }
        $bookForm = $this->createForm(new BookFormType(),$book,
            array(
                'action' => $this->generateUrl('edit_book',array('id'=>$id)),
                'method' => 'POST',
            ));

        $bookForm->handleRequest($request);
        if ($bookForm->isValid()) {

            $uploadedFiles = $request->files->get('book');
            $helper=$this->get('helper.path');
            if ($uploadedFiles['fileBook'])
            {
                /* @var UploadedFile $bookUpload*/
                $bookUpload= $uploadedFiles['fileBook'];
                $fileBook=$helper->moveFile($bookUpload);
                $book->setFileBook($fileBook);
            }

            if ($uploadedFiles['cover'])
            {
                /* @var UploadedFile $bookUpload*/
                $bookUpload= $uploadedFiles['cover'];
                $cover=$helper->moveFile($bookUpload);
                $book->setCover($cover);
            }

//            $this->getDoctrine()->getManager()->persist($book);
//            $this->getDoctrine()->getManager()->flush();
            $bookRepository->save($book);
            return $this->redirect(
                $this->generateUrl('edit_book',array('id'=>$book->getId()))
            );
        }
        return array('book'=>$book,'form'=>$bookForm->createView());
    }





//    /**
//     * @param $abonent
//     * @return \Symfony\Component\Form\Form
//     * @internal param Resume $resume
//     */
//    private function createBlockedForm($abonent)
//    {
//        $form=$this->createForm(new BookFormType(),null,
//            array(
//                'action' => $this->generateUrl('abonent_rest_blocked'),
//                'method' => 'POST',
//            ));
//        $form->add('abonent', 'hidden', array(
//            'data' => $abonent->getId(),
//        ));
//        return $form;
//    }

}
