<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    /**
     * @Route("/addCategory", name="add_category")
     */
    public function addCategory(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $category = new Category();
        $category->setName('Croquette');

        $entityManager->persist($category);
        $entityManager->flush();

        return new Response('La catégorie a été ajoutée '.$category->getName());
    }

}
