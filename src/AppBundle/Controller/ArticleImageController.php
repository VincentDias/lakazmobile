<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ArticleImage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Articleimage controller.
 *
 * @Route("articleimage")
 */
class ArticleImageController extends Controller
{
    /**
     * Lists all articleImage entities.
     *
     * @Route("/", name="articleimage_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articleImages = $em->getRepository('AppBundle:ArticleImage')->findAll();

        return $this->render('articleimage/index.html.twig', array(
            'articleImages' => $articleImages,
        ));
    }

    /**
     * Creates a new articleImage entity.
     *
     * @Route("/new", name="articleimage_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $articleImage = new Articleimage();
        $form = $this->createForm('AppBundle\Form\ArticleImageType', $articleImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $file stores the uploaded file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $articleImage->getPathImage();
            

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move($this->getParameter('article_image_directory'), $fileName);


            // updates the 'image' property to store the file name
            // instead of its contents
            $articleImage->setPathImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($articleImage);
            $em->flush();

            return $this->redirectToRoute('articleimage_show', array('id' => $articleImage->getId()));
        }

        return $this->render('articleimage/new.html.twig', array(
            'articleImage' => $articleImage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a articleImage entity.
     *
     * @Route("/{id}", name="articleimage_show")
     * @Method("GET")
     */
    public function showAction(ArticleImage $articleImage)
    {
        $deleteForm = $this->createDeleteForm($articleImage);

        return $this->render('articleimage/show.html.twig', array(
            'articleImage' => $articleImage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing articleImage entity.
     *
     * @Route("/{id}/edit", name="articleimage_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ArticleImage $articleImage)
    {
        $deleteForm = $this->createDeleteForm($articleImage);
        $editForm = $this->createForm('AppBundle\Form\ArticleImageType', $articleImage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('articleimage_edit', array('id' => $articleImage->getId()));
        }

        return $this->render('articleimage/edit.html.twig', array(
            'articleImage' => $articleImage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a articleImage entity.
     *
     * @Route("/{id}", name="articleimage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ArticleImage $articleImage)
    {
        $form = $this->createDeleteForm($articleImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($articleImage);
            $em->flush();
        }

        return $this->redirectToRoute('articleimage_index');
    }

    /**
     * Creates a form to delete a articleImage entity.
     *
     * @param ArticleImage $articleImage The articleImage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ArticleImage $articleImage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('articleimage_delete', array('id' => $articleImage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
