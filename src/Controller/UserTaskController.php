<?php

namespace App\Controller;

use App\Entity\TaskMilestones;
use App\Entity\UserTask;
use App\Form\UserTaskType;
use App\Repository\CategoryRepository;
use App\Repository\TaskMilestonesRepository;
use App\Repository\UserTaskRepository;
use DateInterval;
use DateTime;
use DateTimeZone;
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
            'user_tasks' => $userTaskRepository->createQueryBuilder('u')
                ->where('u.owner = '.$this->getUser()->getId())
                ->getQuery()
                ->getResult()
            ,
            // 'user_tasks' => $userTaskRepository->findAll($orderBy = ['dueDate' => 'asc']),
        ]);
    }
    
    /**
     * @Route("/weekly", name="user_task_weekly", methods={"GET"})
     */
    public function weekly(UserTaskRepository $userTaskRepository, CategoryRepository $catRep): Response
    {
        $endDate = new DateTime('now', new DateTimeZone('Pacific/Port_Moresby'));
        $startDate = $endDate->sub(new DateInterval('P7D'));
        $cats = $catRep->findAll();
        $completedTasks = $userTaskRepository->createQueryBuilder('u')
            ->where('u.completionDate >= :valA')
            ->andWhere('u.owner = '.$this->getUser()->getId())
            ->setParameter('valA', $startDate)
            ->orderBy('u.id','ASC')
            ->getQuery()
            ->getResult()
        ;
        $pendingTasks = $userTaskRepository->createQueryBuilder('u')
            ->where('u.completionDate is null')
            ->andWhere('u.owner = '.$this->getUser()->getId())
            ->orderBy('u.id','ASC')
            ->getQuery()
            ->getResult()
        ;
        $completedByCategory=[];
        foreach ($cats as $cat) {
            array_push($completedByCategory,[$cat->getName() => []]);
        }
        foreach ($completedTasks as $key => $task) {
            foreach ($completedByCategory as $catekey => $cateval) {
                // var_dump(
                //     key($cateval),
                //     // $task->getCategory()->getName(),
                // );
                if (key($cateval) === $task->getCategory()->getName()) {
                    array_push($completedByCategory[$catekey][key($cateval)],$task);
                }
            }
            foreach ($task as $singletask) {
                var_dump($singletask);
            }
        }
        return $this->render('user_task/weekly_tasks.html.twig', [
            'completed_tasks' => $completedTasks,
            'pending_tasks' => $pendingTasks,
            'comcat' => $completedByCategory,
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
            if ($form->getData()->getTaskMilestones()) {
                foreach ($form->getData()->getTaskMilestones() as $milestone) {
                    // $taskMilestone = new TaskMilestones();
                    $milestone->setTask($userTask);
                    $entityManager->persist($milestone);
                }
            }
            $userTask->setOwner($this->getUser());
            $entityManager->persist($userTask);
            $entityManager->flush();

            return $this->redirectToRoute('home');
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
    public function edit(Request $request, UserTask $userTask, TaskMilestonesRepository $tmr): Response
    {
        $form = $this->createForm(UserTaskType::class, $userTask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getData()->getTaskMilestones()) {
                foreach ($form->getData()->getTaskMilestones() as $milestone) {
                    // look for milestone in db,
                    if (!$milestone->getId()) {
                        // create a new milestone and persist if non-existent
                        $tm = new TaskMilestones();
                        $tm->setTitle($milestone->getTitle());
                        $userTask->addTaskMilestone($tm);
                    } else {
                        // $qm = $tmr->find($milestone);
                        // $qm->setTitle($milestone->getTitle());
                        // $qm->setCompleted($milestone->getCompleted());
                        // $userTask->addTaskMilestone($qm);
                    }
                }
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_task_show', ['id' => $userTask->getId()]);
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
