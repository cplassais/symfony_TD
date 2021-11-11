<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function addCategory(ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $category = new Category();

        $category   ->setName('Vermifuge')
                    ->setDescription('Bla bla bla bla bla bla bla bla bla bla');
        $errors = $validator->validate($category);
        if (count($errors) > 0) {

            $errorsString = (string) $errors;

            return $this->render('error/error.html.twig',['error' =>$errorsString]);

        }
        else {

        $entityManager->persist($category);
        $entityManager->flush();

        return new Response('La catégorie a été ajoutée '.$category->getName());
        }
    }
    /**
     * @Route("/allcat", name="display_all")
     */
    public function displayAll() {

        $categories = $this   ->getDoctrine()
            ->getRepository(Category::Class)
            ->findAll();
        //return new Response('Liste des categories: '.$categories);
        return $this->render('category/cat.html.twig',['cat' =>$categories]);
    }

    /**
     * @Route("/userallcat", name="user_display_category")
     */
    public function userDisplayAll() {

        $categories = $this   ->getDoctrine()
            ->getRepository(Category::Class)
            ->findAll();
        //return new Response('Liste des categories: '.$categories);
        return $this->render('user/userCat.html.twig',['cat' =>$categories]);
    }
    /**
     * @Route("/category/{id}", name="display_category")
     */
    public function displayCategory($id)
    {

        $category = $this   ->getDoctrine()
            ->getRepository(Category::Class)
            ->find($id);
        //return new Response('le nom de la categorie est : '.$category->getName());
        return $this->render('category/singleCat.html.twig', ['cat' => $category]);
    }
    /**
     * @Route("/user_category/{id}", name="display_category_user")
     */
    public function userDisplayCategory($id)
    {

        $category = $this   ->getDoctrine()
            ->getRepository(Category::Class)
            ->find($id);
        //return new Response('le nom de la categorie est : '.$category->getName());
        return $this->render('user/userSingleCat.html.twig', ['cat' => $category]);
    }

    /**
     * @Route("/nameonly", name="name_only")
     */
    public function displayName() {

        $singleFields = $this   ->getDoctrine()
            ->getRepository(Category::Class)
            ->onlyName();
        return $this->render('category/cat.html.twig',['singleFields' =>$singleFields]);
    }
    /**
     * @Route("/category/edit/{id}", name="category_update")
     */
    public function update(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = $entityManager->getRepository(Category::class)->find($id);
        if(!$category){
            return $this->render('error/error.html.twig',['error' => 'La catégories n\'existe pas'] );
        }
        $category->setName('Nouveau nom de la catégorie');
        $entityManager->flush();
        return $this->redirectToRoute('display_category', [
            'id' => $category->getId()
        ]);
    }
    /**
     * @Route("/category/delete/{id}", name="category_delete")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = $entityManager->getRepository(Category::class)->find($id);
        if(!$category){
            return $this->render('error/error.html.twig',['error' => 'La catégorie n\'existe pas'] );
        }
        $entityManager->remove($category);
        $entityManager->flush();
        return $this->redirectToRoute('name_only');
    }
}


