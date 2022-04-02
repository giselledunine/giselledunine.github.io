<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LstUserController extends AbstractController
{
    /**
     * @Route("/lstuser", name="lst_user")
     */
    public function index(): Response
    {
        $lstUsers = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('lst_user/index.html.twig', [
            'lstUsers' => $lstUsers,
        ]);
    }
}
