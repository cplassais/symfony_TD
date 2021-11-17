<?php

namespace App\Controller;

use App\Form\BrandFormType;
use App\Entity\Brand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class BrandController extends AbstractController
{
    /**
     * @Route("/brand", name="brand")
     */
    public function index(): Response
    {
        return $this->render('brand/index.html.twig', [
            'controller_name' => 'BrandController',
        ]);
    }
    /**
     * @Route("/addBrand", name="add_brand")
     */
    public function addBrand(Request $request, ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $brand = new Brand();
        $form = $this->createForm(BrandFormType::class, $brand);
        $form->handleRequest($request);
        $errors = $validator->validate($brand);
        if ($form->isSubmitted() && $form->isValid()) {
            if (count($errors) > 0) {
                $errorsString = (string)$errors;
                return $this->render('error/error.html.twig', ['error' => $errorsString]);
            } else {
                $entityManager->persist($brand);
                $entityManager->flush();
                return $this->redirectToRoute('brand_all');
            }
        }
        return $this->render('brand/addBrand.html.twig', ['brandForm' => $form->createView()]);
    }
    /**
     * @Route("/brand/edit/{id}", name="brand_update")
     */
    public function update(int $id, Request $request, ValidatorInterface $validator ): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $brand = $entityManager->getRepository(Brand::class)->find($id);
        if (!$brand) {
            return $this->render('error/error.html.twig', ['error' => 'La catégories n\'existe pas']);
        }
        $form = $this->createForm(BrandFormType::class, $brand);
        $form->handleRequest($request);
        $errors = $validator->validate($brand);
        if ($form->isSubmitted() && $form->isValid()) {
            if (count($errors) > 0) {
                $errorsString = (string)$errors;
                return $this->render('error/error.html.twig', ['error' => $errorsString]);
            } else {
                //$entityManager->persist($brand);
                $entityManager->flush();
                return $this->redirectToRoute('brand_all');
            }
        }
        return $this->render('brand/addBrand.html.twig', ['brandForm' => $form->createView()]);

    }

    /**
     * @Route("/allbrand", name="brand_all")
     */
    public function displayAll()
    {

        $brands = $this->getDoctrine()
            ->getRepository(Brand::Class)
            ->findAll();
        //return new Response('Liste des brands: '.$brands);
        return $this->render('brand/brand.html.twig', ['cat' => $brands]);
    }

    /**
     * @Route("/userallbrand", name="user_display_brand")
     */
    public function userDisplayAll()
    {

        $brands = $this->getDoctrine()
            ->getRepository(Brand::Class)
            ->findAll();
        //return new Response('Liste des brands: '.$brands);
        return $this->render('user/userBrand.html.twig', ['cat' => $brands]);
    }

    /**
     * @Route("/brand/{id}", name="display_brand")
     */
    public function displayBrand($id)
    {

        $brand = $this->getDoctrine()
            ->getRepository(Brand::Class)
            ->find($id);
        //return new Response('le nom de la catégorie est : '.$brand->getName());
        return $this->render('brand/singleBrand.html.twig', ['cat' => $brand]);
    }

    /**
     * @Route("/user_brand/{id}", name="display_brand_user")
     */
    public function userDisplayBrand($id)
    {

        $brand = $this->getDoctrine()
            ->getRepository(Brand::Class)
            ->find($id);
        //return new Response('le nom de la categorie est : '.$brand->getName());
        return $this->render('user/userSingleBrand.html.twig', ['cat' => $brand]);
    }

    /**
     * @Route("/nameonly", name="name_only")
     */
    public function displayName()
    {

        $singleFields = $this->getDoctrine()
            ->getRepository(Brand::Class)
            ->onlyName();
        return $this->render('brand/brand.html.twig', ['singleFields' => $singleFields]);
    }

    /**
     * @Route("/brand/delete/{id}", name="brand_delete")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $brand = $entityManager->getRepository(Brand::class)->find($id);
        if (!$brand) {
            return $this->render('error/error.html.twig', ['error' => 'La catégorie n\'existe pas']);
        }
        $entityManager->remove($brand);
        $entityManager->flush();
        return $this->redirectToRoute('brand_all');
    }
}
