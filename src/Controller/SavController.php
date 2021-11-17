<?php

namespace App\Controller;

use App\Form\SavType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Mailjet\Resources;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SavController extends AbstractController
{
    /**
     * @Route("/sav", name="app_sav")
     */
    public function index(Request $request): Response
    {

        $form = $this->createForm(SavType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()):

            $savFormData = $form->getData();

            $api_key = '55618957ac33d2032db11b0560c2baba';
            $api_key_private = '8b78bca18a537d19d04131be64b2c309';

            $mj = new \Mailjet\Client($api_key, $api_key_private, true, ['version' => 'v3.1']);
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => $savFormData['Email'],
                            'Commande' => $savFormData['Commande'],
                        ],
                        'To' => [
                            [
                                'Email' => "plassais.christophe@gmail.com",
                                'Name' => "ChrisP"
                            ]
                        ],
                        'Subject' => "Envoi Fiche SAV.",
                        'TextPart' => $savFormData['Motif'],
                        'HTMLPart' => $savFormData['Message'],
                        'CustomID' => "AppGettingStartedTest"
                    ]
                ]
            ];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            $response->success() && var_dump($response->getData());
            return $this->redirectToRoute('sav');
        endif;

        return $this->render('sav/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

