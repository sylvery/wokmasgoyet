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
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        return $this->redirectToRoute('user_task_index');
    }
}
