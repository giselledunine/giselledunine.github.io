<?php

namespace App\Controller;

use App\Entity\Images;
use App\Form\ImagesType;
use App\Repository\ImagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/images")
 */
class ImagesController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="images_index", methods={"GET"})
     */
    public function index(ImagesRepository $imagesRepository): Response
    {
        return $this->render('images/index.html.twig', [
            'images' => $imagesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="images_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $image = new Images();
        $image->setUser($this->security->getUser());
        $form = $this->createForm(ImagesType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('images_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('images/new.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="images_show", methods={"GET"})
     */
    public function show(Images $image): Response
    {
        return $this->render('images/show.html.twig', [
            'image' => $image,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="images_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Images $image, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ImagesType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('images_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('images/edit.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="images_delete", methods={"POST"})
     */
    public function delete(Request $request, Images $image, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('images_index', [], Response::HTTP_SEE_OTHER);
    }
}
