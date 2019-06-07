<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Planning;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Planning controller.
 *
 * @Route("planning-de-la-kaz-mobile")
 */
class PlanningController extends Controller
{
    /**
     * Lists all planning entities.
     *
     * @Route("/", name="planning_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plannings = $em->getRepository('AppBundle:Planning')->findAll();

        return $this->render('planning/index.html.twig', array(
            'plannings' => $plannings,
        ));
    }

    /**
     * Creates a new planning entity.
     *
     * @Route("/admin/new", name="planning_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $planning = new Planning();
        $form = $this->createForm('AppBundle\Form\PlanningType', $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $file stores the uploaded file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $planning->getPath();
            
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('planning_directory'), $fileName);

            $planning->setPath($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($planning);
            $em->flush();

            return $this->redirectToRoute('planning_show', array('id' => $planning->getId()));
        }

        return $this->render('planning/new.html.twig', array(
            'planning' => $planning,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a planning entity.
     *
     * @Route("/{id}", name="planning_show")
     * @Method("GET")
     */
    public function showAction(Planning $planning)
    {
        $deleteForm = $this->createDeleteForm($planning);

        return $this->render('planning/show.html.twig', array(
            'planning' => $planning,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing planning entity.
     *
     * @Route("/admin/{id}/edit", name="planning_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Planning $planning)
    {
        $deleteForm = $this->createDeleteForm($planning);
        $editForm = $this->createForm('AppBundle\Form\PlanningType', $planning);
        $editForm->handleRequest($request);

        $image=$planning->getPath();
        $path=$this->getParameter('planning_directory').'/'.$image;

        $fs= new Filesystem();
        $fs->remove(array($path));

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // $file stores the uploaded file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $planning->getPath();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move($this->getParameter('planning_directory'), $fileName);
            
            // updates the 'image' property to store the file name
            // instead of its contents
            $planning->setPath($fileName);




            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('planning_index', array('id' => $planning->getId()));
        }

        return $this->render('planning/edit.html.twig', array(
            'planning' => $planning,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a planning entity.
     *
     * @Route("admin/{id}", name="planning_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Planning $planning)
    {
        $form = $this->createDeleteForm($planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($planning);
            $em->flush();
        }

        return $this->redirectToRoute('planning_index');
    }

    /**
     * Creates a form to delete a planning entity.
     *
     * @param Planning $planning The planning entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Planning $planning)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('planning_delete', array('id' => $planning->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
