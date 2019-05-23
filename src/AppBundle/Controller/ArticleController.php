<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Article controller.
 *
 * @Route("articles")
 */
class ArticleController extends Controller
{
    /**
     * Lists all article entities.
     *
     * @Route("/", name="article_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('AppBundle:Article')->findAll();

        return $this->render('article/index.html.twig', array(
            'articles' => $articles,
        ));
    }

    /**
     * Creates a new article entity.
     *
     * @Route("/new", name="article_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm('AppBundle\Form\ArticleType', $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $file stores the uploaded file
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $article->getArticleImage()->getPathImage();
    
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
    
                $file->move($this->getParameter('article_image_directory'), $fileName);
                
                // updates the 'image' property to store the file name
                // instead of its contents
                $article->getArticleImage()->setPathImage($fileName);

                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();
    
                // ... persist the $plat variable or any other work
    
                return $this->redirect($this->generateUrl('article_index'));
            }
    
            return $this->render('article/new.html.twig', [
                'form' => $form->createView(),
            ]);
        }



    /**
     * Finds and displays a article entity.
     *
     * @Route("/{id}", name="article_show")
     * @Method("GET")
     */
    public function showAction(Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);

        return $this->render('article/show.html.twig', array(
            'article' => $article,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing article entity.
     *
     * @Route("/{id}/edit", name="article_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->createForm('AppBundle\Form\ArticleType', $article);
        $editForm->handleRequest($request);

        $image=$article->getArticleImage();
        $pathImage=$this->getParameter('article_image_directory').'/'.$image;
        //unlink(''.$path);
        $fs= new Filesystem();
        $fs->remove(array($pathImage));


        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // $file stores the uploaded file
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $article->getArticleImage()->getPathImage();
    
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
    
                $file->move($this->getParameter('article_image_directory'), $fileName);
                
                // updates the 'image' property to store the file name
                // instead of its contents
                $article->getArticleImage()->setPathImage($fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index', array('id' => $article->getId()));
        }

        return $this->render('article/edit.html.twig', array(
            'article' => $article,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a article entity.
     *
     * @Route("/{id}/delete", name="article_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Article $article)
    {
        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image=$article->getArticleImage()->getPathImage();
            $pathImage=$this->getParameter('article_image_directory').'/'.$image;
            //unlink(''.$path);
            $fs= new Filesystem();
            $fs->remove(array($pathImage));


            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('article_index');
    }

    /**
     * Creates a form to delete a article entity.
     *
     * @param Article $article The article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('article_delete', array('id' => $article->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
