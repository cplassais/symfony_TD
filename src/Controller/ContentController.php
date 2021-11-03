<?php
// src/Controller/ContentController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ContentController extends AbstractController {
    public function display(string $title): Response {
        return $this->render('content/content.html.twig', [
            'title' => $title,
            'description' => 'contenu de la page'
        ]);
    }
}