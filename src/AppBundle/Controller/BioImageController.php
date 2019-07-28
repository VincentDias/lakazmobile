<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BioImage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Bioimage controller.
 *
 * @Route("bioimage")
 */
class BioImageController extends Controller
{
    
    /**
     * Creates a new bioImage entity.
     *
     * @Route("/new", name="bioimage_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $bioImage = new Bioimage();
        $form = $this->createForm('AppBundle\Form\BioImageType', $bioImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $bioImage->getPathImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('bio_directory'), $fileName);


            // updates the 'image' property to store the file name
            // instead of its contents
            $bioImage->setPathImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($bioImage);
            $em->flush();

            return $this->redirectToRoute('bioimage_show', array('id' => $bioImage->getId()));
        }

        return $this->render('bioimage/new.html.twig', array(
            'bioImage' => $bioImage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a bioImage entity.
     *
     * @Route("/{id}", name="bioimage_show")
     * @Method("GET")
     */
    public function showAction(BioImage $bioImage)
    {
        $deleteForm = $this->createDeleteForm($bioImage);

        return $this->render('bioimage/show.html.twig', array(
            'bioImage' => $bioImage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing bioImage entity.
     *
     * @Route("/{id}/edit", name="bioimage_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BioImage $bioImage)
    {
        $editForm = $this->createForm('AppBundle\Form\BioImageType', $bioImage);
        $editForm->handleRequest($request);

        $image=$bioImage->getPathImage();
        $pathImage=$this->getParameter('bio_directory').'/'.$image;

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // $file stores the uploaded file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $bioImage->getPathImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('bio_directory'), $fileName);

            // updates the 'image' property to store the file name
            // instead of its contents
            $bioImage->setPathImage($fileName);

            $this->getDoctrine()->getManager()->flush();
            $fs= new Filesystem();
            $fs->remove(array($pathImage));

            return $this->redirectToRoute('bio_index', array('id' => $bioImage->getId()));
        }

        return $this->render('bioimage/edit.html.twig', array(
            'bioImage' => $bioImage,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a bioImage entity.
     *
     * @Route("/{id}", name="bioimage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BioImage $bioImage)
    {
        $form = $this->createDeleteForm($bioImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bioImage);
            $em->flush();
        }

        return $this->redirectToRoute('bioimage_index');
    }

    /**
     * Creates a form to delete a bioImage entity.
     *
     * @param BioImage $bioImage The bioImage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BioImage $bioImage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bioimage_delete', array('id' => $bioImage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
