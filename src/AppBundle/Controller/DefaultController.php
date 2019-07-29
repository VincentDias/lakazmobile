<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @Route("/contact/api", name="contact_api", methods={"POST"})
     */
    public function contactApiAction(Request $request, \Swift_Mailer $mailer)
    {               
            $firstname = isset($_POST['firstname']) && !empty($_POST['firstname']) ?  $_POST['firstname'] : '';
            $lastname = isset($_POST['lastname']) && !empty($_POST['lastname']) ?  $_POST['lastname'] : '';
            $email = isset($_POST['email']) && !empty($_POST['email']) ?  $_POST['email'] : '';
            $phone_number = isset($_POST['phone_number']) && !empty($_POST['phone_number']) ?  $_POST['phone_number'] : '';
            $entitled = isset($_POST['entitled']) && !empty($_POST['entitled']) ?  $_POST['entitled'] : '';
            $message = isset($_POST['message']) && !empty($_POST['message']) ?  $_POST['message'] : '';
            $captcha = $_POST['captcha'];
            
            $recaptcha = new \ReCaptcha\ReCaptcha('6LdVZKcUAAAAAFePwGI8_YOnnGeaLO3Cz-827zN8');
            $resp = $recaptcha->verify($captcha);

            $validation = false;
            $sent = false;
            if ($resp->isSuccess()) {
                $validation = true;
                $message = (new \Swift_Message('Nouvelle demande'))
                    ->setFrom('lakazmobile.test@gmail.com')
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

                $sent = $mailer->send($message);
            }
            
            
            /*$recaptcha = new \ReCaptcha\ReCaptcha('6LdVZKcUAAAAAFePwGI8_YOnnGeaLO3Cz-827zN8');
            $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'));

            if ($resp->isSuccess()) {
                $message = (new \Swift_Message('Nouvelle demande'))
                    ->setFrom('lakazmobile.test@gmail.com')
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

                return new JsonResponse([ "response" => "ok" ], 200);
            } else {
            $errors = $resp->getErrorCodes();
            return new JsonResponse([ "response" => $errors ], 400);
            } */
        
        return new JsonResponse([ "response" =>  [
            
            "validation" => $validation,
            "sent" => $sent
            ]
        ], 200);
        
    }


    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request, \Swift_Mailer $mailer)
    {    
        // replace this example code with whatever you need
        $is_submit = false;
        if($request->isMethod('post')) {            
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
                $is_submit = true;

            } else {
            $errors = $resp->getErrorCodes();
            
            }
            

        } 
        
        return $this->render(
            'default/contact.html.twig', 
            ['is_submit' => $is_submit,
            ]
        );
        
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
