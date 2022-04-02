<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\AjoutPostFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedController extends AbstractController
{
    /**
     * @Route("/feed", name="feed")
     */
    public function index(Request $request): Response
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findBY(array(),['id'=>'DESC']);
        $newPost = new Post();
        $form = $this->createForm(AjoutPostFormType::class, $newPost);

        $newPost->setCreatedAt(date_create('now'));


        $form = $this->createForm(AjoutPostFormType::class, $newPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $newPost->setUser($this->getUser());
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($newPost);
            $doctrine->flush();

            $this->addFlash('message', 'Votre post a bien été publié');
            return $this->redirectToRoute('feed');
        }

        return $this->render('feed/index.html.twig', [
            'posts' => $posts,
            'postForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
