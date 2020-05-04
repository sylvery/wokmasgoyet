<?php

namespace App\Controller;

use App\Entity\UserTask;
use App\Form\UserTaskType;
use App\Repository\UserTaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/task")
 */
class UserTaskController extends AbstractController
{
    /**
     * @Route("/", name="user_task_index", methods={"GET"})
     */
    public function index(UserTaskRepository $userTaskRepository): Response
    {
        return $this->render('user_task/index.html.twig', [
            'user_tasks' => $userTaskRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_task_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userTask = new UserTask();
        $form = $this->createForm(UserTaskType::class, $userTask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userTask);
            $entityManager->flush();

            return $this->redirectToRoute('user_task_index');
        }

        return $this->render('user_task/new.html.twig', [
            'user_task' => $userTask,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_task_show", methods={"GET"})
     */
    public function show(UserTask $userTask): Response
    {
        return $this->render('user_task/show.html.twig', [
            'user_task' => $userTask,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_task_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserTask $userTask): Response
    {
        $form = $this->createForm(UserTaskType::class, $userTask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_task_index');
        }

        return $this->render('user_task/edit.html.twig', [
            'user_task' => $userTask,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_task_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserTask $userTask): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userTask->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userTask);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_task_index');
    }
}
