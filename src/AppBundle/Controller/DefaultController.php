<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/articles", name="articles")
     */
    public function articlesAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/articles.html.twig');
    }

    /**
     * @Route("/a-propos", name="a_propos")
     */
    public function aproposAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/a-propos.html.twig');
    }

    /**
     * @Route("/nos-menus", name="nos_menus")
     */
    public function nosmenusAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/nos-menus.html.twig');
    }

    /**
     * @Route("/planning", name="planning")
     */
    public function planningAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/planning.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        // replace this example code with whatever you need
        if($request->isMethod('post')){ 
            var_dump($_POST);
        }
        return $this->render('default/contact.html.twig');
        
    }
    
}
