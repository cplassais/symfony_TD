<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function addProduct(Request $request, ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = new Product();
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);
        $errors = $validator->validate($product);
        if ($form->isSubmitted() && $form->isValid()) {
            if (count($errors) > 0) {
                $errorsString = (string)$errors;
                return $this->render('error/error.html.twig', ['error' => $errorsString]);
            } else {
                $entityManager->persist($product);
                $entityManager->flush();
                return $this->redirectToRoute('product_all');
            }
        }
        return $this->render('product/addProduct.html.twig', ['productForm' => $form->createView()]);
    }

    /**
     * @Route("/product/{id}", name="display_product")
     */
    public function displayProduct($id)
    {

        $product = $this->getDoctrine()
            ->getRepository(Product::Class)
            ->find($id);
        //return new Response('le nom du produit est : ' . $product->getName());
        return $this->render('product/singleProd.html.twig', ['prod' => $product]);
    }
    /**
     * @Route("/user_product/{id}", name="display_product_user")
     */
    public function displayUserProduct($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::Class)
            ->find($id);
        //return new Response('le nom du produit est : ' . $product->getName());
        return $this->render('user/userSingleProd.html.twig', ['prod' => $product]);
    }
    /**
     * @Route("/allprod", name="product_all")
     */
    public function displayAll()
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::Class)
            ->findAll();
        //return new Response('Liste des categories: '.$categories);
        return $this->render('product/prod.html.twig', ['prod' => $products]);
    }
    /**
     * @Route("/userallprod", name="user_product_all")
     */
    public function userDisplayAll()
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::Class)
            ->findAll();
        //return new Response('Liste des categories: '.$categories);
        return $this->render('user/userProd.html.twig', ['prod' => $products]);
    }

    /**
     * @Route("/onlypro", name="product_only")
     */
    public function displayName()
    {

        $singleFields = $this->getDoctrine()
            ->getRepository(Product::Class)
            ->onlyName();
        return $this->render('product/cat.html.twig', ['singleFields' => $singleFields]);
    }

    /**
     * @Route("/product/edit/{id}", name="product_update")
     */
    public function update(int $id, Request $request, ValidatorInterface $validator ): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);
        if (!$product) {
            return $this->render('error/error.html.twig', ['error' => 'Le produit n\'existe pas']);
        }
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);
        $errors = $validator->validate($product);
        if ($form->isSubmitted() && $form->isValid()) {
            if (count($errors) > 0) {
                $errorsString = (string)$errors;
                return $this->render('error/error.html.twig', ['error' => $errorsString]);
            } else {
                $entityManager->persist($product);
                $entityManager->flush();
                return $this->redirectToRoute('product_all');
            }
        }
        return $this->render('product/addProduct.html.twig', ['productForm' => $form->createView()]);

    }

    /**
     * @Route("/product/delete/{id}", name="product_delete")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);
        if(!$product){
            return $this->render('error/error.html.twig',['error' => 'Le produit n\'existe pas'] );
        }
        $entityManager->remove($product);
        $entityManager->flush();
        return $this->redirectToRoute('product_all');
    }

}
