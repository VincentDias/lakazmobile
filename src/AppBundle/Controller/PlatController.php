<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Plat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Plat controller.
 *
 * @Route("les-menus-de-la-kaz-mobile")
 */
class PlatController extends Controller
{
    /**
     * Lists all plat entities.
     *
     * @Route("/", name="plat_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        

        $entrees = $em->getRepository('AppBundle:Plat')->findBy(
            array("categoryName"=>1, "available"=>1)
        );
        $plats = $em->getRepository('AppBundle:Plat')->findBy(
            array("categoryName"=>2, "available"=>1)
        );
        $desserts = $em->getRepository('AppBundle:Plat')->findBy(
            array("categoryName"=>3, "available"=>1)
        );
        $boissons = $em->getRepository('AppBundle:Plat')->findBy(
            array("categoryName"=>4, "available"=>1)
        );

        return $this->render('plat/index.html.twig', array(
            'entrees' => $entrees,
            'plats' => $plats,
            'desserts' => $desserts,
            'boissons' => $boissons,
        ));
    }

    /**
     * Creates a new plat entity.
     *
     * @Route("/new", name="plat_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $plat = new Plat();
        $form = $this->createForm('AppBundle\Form\PlatType', $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // $file stores the uploaded file
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $plat->getImage()->getPathImage();
    
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
    
                $file->move($this->getParameter('image_directory'), $fileName);

                
                // updates the 'image' property to store the file name
                // instead of its contents
                $plat->getImage()->setPathImage($fileName);

                $em = $this->getDoctrine()->getManager();
                $em->persist($plat);
                $em->flush();
    
                // ... persist the $plat variable or any other work
    
                return $this->redirect($this->generateUrl('plat_index'));
            }
    
            return $this->render('plat/new.html.twig', [
                'form' => $form->createView(),
            ]);
        }

         

    /**
     * Finds and displays a plat entity.
     *
     * @Route("/{id}", name="plat_show")
     * @Method("GET")
     */
    public function showAction(Plat $plat)
    {
        $deleteForm = $this->createDeleteForm($plat);

        return $this->render('plat/show.html.twig', array(
            'plat' => $plat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing plat entity.
     *
     * @Route("/{id}/edit", name="plat_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Plat $plat)
    {
        $deleteForm = $this->createDeleteForm($plat);
        $editForm = $this->createForm('AppBundle\Form\PlatType', $plat);
        $editForm->handleRequest($request);

        $image=$plat->getImage()->getPathImage();
        $pathImage=$this->getParameter('image_directory').'/'.$image;
        //unlink(''.$path);
        $fs= new Filesystem();
        $fs->remove(array($pathImage));


        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // $file stores the uploaded file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $plat->getImage()->getPathImage();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move($this->getParameter('image_directory'), $fileName);

            
            // updates the 'image' property to store the file name
            // instead of its contents
            $plat->getImage()->setPathImage($fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plat_index', array('id' => $plat->getId()));
        }

        return $this->render('plat/edit.html.twig', array(
            'plat' => $plat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a plat entity.
     *
     * @Route("/{id}/delete}", name="plat_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Plat $plat)
    {
        $form = $this->createDeleteForm($plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image=$plat->getImage()->getPathImage();
            $pathImage=$this->getParameter('image_directory').'/'.$image;
            //unlink(''.$path);
            $fs= new Filesystem();
            $fs->remove(array($pathImage));


            $em = $this->getDoctrine()->getManager();
            $em->remove($plat);
            $em->flush();
        }

        return $this->redirectToRoute('plat_index');
    }

    /**
     * Creates a form to delete a plat entity.
     *
     * @param Plat $plat The plat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Plat $plat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plat_delete', array('id' => $plat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
