<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Form\BookFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     * @Security("has_role('ROLE_ADMIN')")
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


    /**
     * @Route("/delete/{id}", name="delete_book", requirements={"id": "\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return array
     */
    public function deleteBookAction(Request $request)
    {
        $id = (int)$request->get('id');
        $bookRepository=$this->getDoctrine()->getRepository('AppBundle:Book');
        $book=$bookRepository->find($id);
        if ($book)
        {
            $bookRepository->delete(array($book->getId()));
            return $this->redirect(
                $this->generateUrl('homepage'));

        }
        throw $this->createNotFoundException('The book does not exist');
    }

    /**
     * @Route("/delete-book-cover/{id}", name="delete_book_cover", requirements={"id": "\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return array
     */
    public function deleteBookCoverAction(Request $request)
    {
        $id = (int)$request->get('id');
        $bookRepository=$this->getDoctrine()->getRepository('AppBundle:Book');
        $book=$bookRepository->find($id);
        if ($book &&  $cover=$book->getCover())
        {
            $helper=$this->get('helper.path');
            $helper->deleteFile($cover);
            $book->setCover('');
            $bookRepository->save($book);
            return $this->redirect(
                $this->generateUrl('edit_book',array('id'=>$book->getId())));
        }
        throw $this->createNotFoundException('The cover book does not exist');
    }


    /**
     * @Route("/delete-book-file/{id}", name="delete_book_file", requirements={"id": "\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return array
     */
    public function deleteBookFileAction(Request $request)
    {
        $id = (int)$request->get('id');
        $bookRepository=$this->getDoctrine()->getRepository('AppBundle:Book');
        $book=$bookRepository->find($id);
        if ($book && $file=$book->getFileBook())
        {
            $helper=$this->get('helper.path');
            $helper->deleteFile($file);
            $book->setFileBook('');
            $bookRepository->save($book);
            return $this->redirect(
                $this->generateUrl('edit_book',array('id'=>$book->getId())));
        }
        throw $this->createNotFoundException('The file book does not exist');
    }

}
