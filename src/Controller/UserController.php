<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Post;
use App\Entity\User;
use App\Form\AjoutPostFormType;
use App\Form\AvatarType;
use App\Form\ImagesType;
use App\Form\UserSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Form\UserType;

class UserController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/user", name="user")
     */
    public function index(Request $request, Security $security,UserInterface $user, EntityManagerInterface $entityManager):Response
    {
        $id = $user->getId();

        $avatar = $this->createForm(AvatarType::class, $user);
        $avatar->handleRequest($request);

        if ($avatar->isSubmitted() && $avatar->isValid()){
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($user);
            $doctrine->flush();

            $this->addFlash('message', 'Votre image de profil a été modifié');
            return $this->redirectToRoute('user');
        }

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
            return $this->redirectToRoute('user');
        }

        $image = new Images();
        $image->setUser($this->security->getUser());
        $formImage = $this->createForm(ImagesType::class, $image);
        $formImage->handleRequest($request);

        if ($formImage->isSubmitted() && $formImage->isValid()) {
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }

        $posts = $this->getDoctrine()->getRepository(Post::class)->findBy(array('user' => $id), ['id' => 'DESC']);
        return $this->render('user/index.html.twig', [
            'id' => $id,
            'avatar' => $avatar->createView(),
            'posts' => $posts,
            'postForm' => $form->createView(),
            'imageForm' => $formImage->createView(),
        ]);
    }

    public function search(): Response
    {
        $search = $this->createForm( UserSearchType::class);

        return $this->render('user/search.html.twig', [
            'searchform' => $search->createView()
        ]);
    }

    /**
     * @Route("user/{id}", name="one_user", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/oneUser.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/search", name="search")
     */

    public function handleSearch(Request $request ): Response
    {

        $name = $request->request->get('user_search')['search'];

        $result = $this->getDoctrine()->getRepository(User::class)->findByExampleField($name);

        return $this->render('user/showSearch.html.twig', [
            'users' => $result
        ]);
    }

    /**
     * @Route("/update", name="update")
     */

    public  function update(Request $request, Security  $security, UserInterface  $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($user);
            $doctrine->flush();

            $this->addFlash('message', 'Votre post a bien été publié');
            return $this->redirectToRoute('user');
        }

        return $this->render('user/update.html.twig', [
            'updateUserForm' => $form->createView(),
        ]);
    }
}