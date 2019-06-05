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

            /*$message = (new \Swift_Message('Hello Email'))
                ->setFrom('send@example.com')
                ->setTo('recipient@example.com')
                ->setBody(
                    $this->renderView(
                        // app/Resources/views/Emails/registration.html.twig
                        'Emails/contact.html.twig',
                        ['name' => $name]
                    ),
                    'text/html'
                )
                
                * If you also want to include a plaintext version of the message
                 ->addPart(
                    $this->renderView(
                        'Emails/contact--.txt.twig',
                        ['name' => $name]
                    ),
                    'text/plain'
                )
            
            ;

        $mailer->send($message);

        // or, you can also fetch the mailer service this way
    // $this->get('mailer')->send($message);

    return $this->render(...);
}
*/




        }
        return $this->render('default/contact.html.twig');
        
    }
    
}
