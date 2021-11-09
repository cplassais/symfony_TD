<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
    /**
     * @Route("/addProduct", name="add_product")
     */
    public function addProduct(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setName('Atheletic Canin');
        $product->setDescription('croquette pour chien');
        $product->setPrice(12.55);

        $entityManager->persist($product);
        $entityManager->flush();

        return new Response('Le produit a été ajoutée '.$product->getName());
    }
    /**
     * @Route("/product/{id}", name="display_product")
     */
    public function displayProduct($id):Response{

        $product = $this   ->getDoctrine()
            ->getRepository(Product::Class)
            ->find($id);
        return new Response('le nom de le produit est : '.$product->getName());
    }
    /**
     * @Route("/allprod", name="product_all")
     */
    public function displayAll():Response{

        $products = $this   ->getDoctrine()
            ->getRepository(Product::Class)
            ->findAll();
        //return new Response('Liste des categories: '.$categories);
        return $this->render('product/prod.html.twig',['prod' =>$products]);
    }
    /**
     * @Route("/onlypro", name="product_only")
     */
    public function displayName() {

        $singleFields = $this   ->getDoctrine()
            ->getRepository(Product::Class)
            ->onlyName();
        return $this->render('category/cat.html.twig',['singleFields' =>$singleFields]);
    }
}
