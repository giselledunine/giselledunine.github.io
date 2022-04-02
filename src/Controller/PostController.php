<?php

namespace App\Controller;

use App\Form\AjoutPostFormType;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     */
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/post/new", name="ajout_post")
     */
    public function ajoutPost(Request $request)
    {
        $post = new Post();
        $post->setCreatedAt(date_create('now'));


        $form = $this->createForm(AjoutPostFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $post->setUser($this->getUser());
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($post);
            $doctrine->flush();

            $this->addFlash('message', 'Votre post a bien été publié');
            return $this->redirectToRoute('feed');
        }
        return $this->render('post/index.html.twig',['postForm'=>$form->createView()]);
    }
}
