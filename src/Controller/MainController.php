<?php

namespace App\Controller;

use App\Repository\UserTaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(UserTaskRepository $tr)
    {
        return $this->render('main/index.html.twig', [
            'tasks' => $tr->findBy(['owner' => $this->getUser()]),
        ]);
    }
}
