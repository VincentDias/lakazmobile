<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Image controller.
 *
 * @Route("image")
 */
class ImageController extends Controller
{
    /**
     * Lists all image entities.
     *
     * @Route("/", name="image_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $images = $em->getRepository('AppBundle:Image')->findAll();

        return $this->render('image/index.html.twig', array(
            'images' => $images,
        ));
    }

    /**
     * Creates a new image entity.
     *
     * @Route("/new", name="image_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $image = new Image();
        $form = $this->createForm('AppBundle\Form\ImageType', $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $file stores the uploaded file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $image->getPathImage();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('image_directory'), $fileName);

            // updates the 'image' property to store the file name
            // instead of its contents
            $image->setPathImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            // ... persist the $plat variable or any other work

            return $this->redirect($this->generateUrl('image_index'));
        }

        return $this->render('image/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    /**
     * Finds and displays a image entity.
     *
     * @Route("/{id}", name="image_show")
     * @Method("GET")
     */
    public function showAction(Image $image)
    {
        $deleteForm = $this->createDeleteForm($image);

        return $this->render('image/show.html.twig', array(
            'image' => $image,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing image entity.
     *
     * @Route("/{id}/edit", name="image_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Image $image)
    {
        $editForm = $this->createForm('AppBundle\Form\ImageType', $image);
        $editForm->handleRequest($request);

        $image_plat=$image->getPathImage();
        $pathImage=$this->getParameter('image_directory').'/'.$image_plat;

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // $file stores the uploaded file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $image->getPathImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('image_directory'), $fileName);

            // updates the 'image' property to store the file name
            // instead of its contents
            $image->setPathImage($fileName);


            $this->getDoctrine()->getManager()->flush();
            $fs= new Filesystem();
            $fs->remove(array($pathImage));

            return $this->redirectToRoute('plat_index');
        }

        return $this->render('image/edit.html.twig', array(
            'image' => $image,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a image entity.
     *
     * @Route("/{id}/delete}", name="image_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Image $image)
    {
        $form = $this->createDeleteForm($image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();
        }

        return $this->redirectToRoute('image_index');
    }

    /**
     * Creates a form to delete a image entity.
     *
     * @param Image $image The image entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Image $image)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('image_delete', array('id' => $image->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
