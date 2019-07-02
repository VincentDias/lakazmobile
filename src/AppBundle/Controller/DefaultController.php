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
    public function contactAction(Request $request, \Swift_Mailer $mailer)
    {    
        // replace this example code with whatever you need
        if($request->isMethod('post')){ 

            
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $entitled = $_POST['entitled'];
            $message = $_POST['message'];

            $recaptcha = new \ReCaptcha\ReCaptcha('6LdVZKcUAAAAAFePwGI8_YOnnGeaLO3Cz-827zN8');
            $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'));
            if ($resp->isSuccess()) {

            


                $message = (new \Swift_Message('Nouvelle demande'))
                    ->setFrom('noreply.lakazmobile@gmail.com')
                    ->setTo('lakazmobile.test@gmail.com')
                    ->setBody(
                        $this->renderView(
                            // app/Resources/views/Emails/registration.html.twig
                            'Emails/contact.html.twig',
                            ['firstname' => $firstname,
                            'lastname' => $lastname,
                            'phone_number' => $phone_number,
                            'email' => $email,
                            'entitled' => $entitled,
                            'message' => $message
                            ]
                        ),
                        'text/html'
                    )
                ;

                $mailer->send($message);

            } else {
            $errors = $resp->getErrorCodes();
            var_dump($errors);
            }
            

        } return $this->render('default/contact.html.twig');
        
    }

    /**
     * @Route("/mentions-légales", name="legalnotice")
     */
    public function legalnoticeAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/legalnotice.html.twig');
    }
        
    
}
