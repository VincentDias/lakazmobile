<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Bio controller.
 *
 * @Route("a-propos")
 */
class BioController extends Controller
{
    /**
     * Lists all bio entities.
     *
     * @Route("/", name="bio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bios = $em->getRepository('AppBundle:Bio')->findAll();

        return $this->render('bio/index.html.twig', array(
            'bios' => $bios,
        ));
    }

    /**
     * Creates a new bio entity.
     *
     * @Route("/new", name="bio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $bio = new Bio();
        $form = $this->createForm('AppBundle\Form\BioType', $bio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $bio->getImage()->getPathImage();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move($this->getParameter('bio_directory'), $fileName);
            
            // updates the 'image' property to store the file name
            // instead of its contents
            $bio->getImage()->setPathImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($bio);
            $em->flush();

            return $this->redirectToRoute('bio_index', array('id' => $bio->getId()));
        }

        return $this->render('bio/new.html.twig', array(
            'bio' => $bio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a bio entity.
     *
     * @Route("/{id}", name="bio_show")
     * @Method("GET")
     */
    public function showAction(Bio $bio)
    {
        
        return $this->render('bio/show.html.twig', array(
            'bio' => $bio
        ));
    }

    /**
     * Displays a form to edit an existing bio entity.
     *
     * @Route("/{id}/edit", name="bio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Bio $bio)
    {
        $editForm = $this->createForm('AppBundle\Form\BioType1', $bio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('bio_index', array('id' => $bio->getId()));
        }

        return $this->render('bio/edit.html.twig', array(
            'bio' => $bio,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a bio entity.
     *
     * @Route("/{id}/delete", name="bio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Bio $bio)
    {
        $form = $this->createDeleteForm($bio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image=$bio->getImage()->getPathImage();
            $pathImage=$this->getParameter('bio_directory').'/'.$image;
            //unlink(''.$path);
            $fs= new Filesystem();
            $fs->remove(array($pathImage));

            $em = $this->getDoctrine()->getManager();
            $em->remove($bio);
            $em->flush();
        }

        return $this->redirectToRoute('bio_index');
    }

    /**
     * Creates a form to delete a bio entity.
     *
     * @param Bio $bio The bio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Bio $bio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bio_delete', array('id' => $bio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
