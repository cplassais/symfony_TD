<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Mailjet\Resources;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request): Response
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()):

            $contactFormData = $form->getData();

            $api_key = '55618957ac33d2032db11b0560c2baba';
            $api_key_private = '8b78bca18a537d19d04131be64b2c309';

            $mj = new \Mailjet\Client($api_key, $api_key_private, true, ['version' => 'v3.1']);
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => $contactFormData['Email'],
                            'Name' => $contactFormData['Nom'],
                        ],
                        'To' => [
                            [
                                'Email' => "plassais.christophe@gmail.com",
                                'Name' => "ChrisP"
                            ]
                        ],
                        'Subject' => "Greetings from Mailjet.",
                        'TextPart' => "My first Mailjet email",
                        'HTMLPart' => $contactFormData['Message'],
                        'CustomID' => "AppGettingStartedTest"
                    ]
                ]
            ];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            $response->success() && var_dump($response->getData());
            return $this->redirectToRoute('contact');

        endif;

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
        $params = array(
            'name' => $request->getParameter('name'),
            'email' => $request->getParameter('email'),
            'message' => $request->getParameter('message'),
        );
    }
}

