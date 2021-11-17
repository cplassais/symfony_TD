<?php
// src/Controller/ContentController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use \Mailjet\Resources;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

class ContentController extends AbstractController {

    public function display(string $title): Response {
//        $api_key='55618957ac33d2032db11b0560c2baba';
//        $api_key_private='8b78bca18a537d19d04131be64b2c309';
//
//        $mj = new \Mailjet\Client($api_key,$api_key_private,true,['version' => 'v3.1']);
//        $body = [
//            'Messages' => [
//                [
//                    'From' => [
//                        'Email' => "plassais.christophe@gmail.com",
//                        'Name' => "ChrisP"
//                    ],
//                    'To' => [
//                        [
//                            'Email' => "plassais.christophe@gmail.com",
//                            'Name' => "ChrisP"
//                        ]
//                    ],
//                    'Subject' => "Greetings from Mailjet.",
//                    'TextPart' => "My first Mailjet email",
//                    'HTMLPart' => "<h3>Nom : </h3>",
//                    'CustomID' => "AppGettingStartedTest"
//                ]
//            ]
//        ];
//        $response = $mj->post(Resources::$Email, ['body' => $body]);
//        $response->success() && var_dump($response->getData());
        return $this->render('content/content.html.twig', [
            'title' => $title,
            'description' => 'contenu de la page'
        ]
        );
    }

}
