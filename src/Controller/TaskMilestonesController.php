<?php

namespace App\Controller;

use App\Entity\TaskMilestones;
use App\Form\TaskMilestonesFullType;
use App\Form\TaskMilestonesType;
use App\Repository\TaskMilestonesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/task/milestones")
 */
class TaskMilestonesController extends AbstractController
{
    /**
     * @Route("/", name="task_milestones_index", methods={"GET"})
     */
    public function index(TaskMilestonesRepository $taskMilestonesRepository): Response
    {
        return $this->render('task_milestones/index.html.twig', [
            'task_milestones' => $taskMilestonesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="task_milestones_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $taskMilestone = new TaskMilestones();
        $form = $this->createForm(TaskMilestonesType::class, $taskMilestone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($taskMilestone);
            $entityManager->flush();

            return $this->redirectToRoute('task_milestones_index');
        }

        return $this->render('task_milestones/new.html.twig', [
            'task_milestone' => $taskMilestone,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="task_milestones_show", methods={"GET"})
     */
    public function show(TaskMilestones $taskMilestone): Response
    {
        return $this->render('task_milestones/show.html.twig', [
            'task_milestone' => $taskMilestone,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="task_milestones_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TaskMilestones $taskMilestone): Response
    {
        $form = $this->createForm(TaskMilestonesFullType::class, $taskMilestone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('task_milestones_index');
        }

        return $this->render('task_milestones/edit.html.twig', [
            'task_milestone' => $taskMilestone,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="task_milestones_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TaskMilestones $taskMilestone): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taskMilestone->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($taskMilestone);
            $entityManager->flush();
        }

        return $this->redirectToRoute('task_milestones_index');
    }
}
