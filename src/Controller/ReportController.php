<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\UserTaskRepository;
use DateInterval;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/report")
 */
class ReportController extends AbstractController
{
    /**
     * @Route("/", name="report")
     */
    public function index(): Response
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }

    /**
     * @Route("/results", name="report_results", methods={"GET","POST"})
     */
    public function results(UserTaskRepository $userTaskRepository, CategoryRepository $catRep): Response
    {
        $req=$_POST;
        // dump($req); exit;
        if ($req != null) {
            $startDate = new DateTime($req['startDate'], new DateTimeZone('Pacific/Port_Moresby'));
            $endDate = new DateTime($req['endDate'], new DateTimeZone('Pacific/Port_Moresby'));
            // dump($startDate, $endDate); exit;
        } 
        // @todo keep working on this one
        // if ($req['reportType'] === 'weekly') {
        //     $startDate = $req['startDate'];
        //     $endDate = $endDate->sub(new DateInterval('P7D'));
        // } else if ($req['reportType'] === 'monthly')

        $cats = $catRep->findAll();
        $completedTasks = $userTaskRepository->createQueryBuilder('u')
            ->where('u.completionDate >= :valA')
            ->andWhere('u.completionDate <= :valB')
            ->andWhere('u.owner = '.$this->getUser()->getId())
            ->setParameter('valA', $startDate)
            ->setParameter('valB', $endDate)
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
        foreach ($completedTasks as $task) {
            foreach ($completedByCategory as $catekey => $cateval) {
                if (key($cateval) === $task->getCategory()->getName()) {
                    array_push($completedByCategory[$catekey][key($cateval)],$task);
                }
            }
        }
        return $this->render('report/layout.html.twig', [
            'completed_tasks' => $completedTasks,
            'pending_tasks' => $pendingTasks,
            'completed_tasks_by_category' => $completedByCategory,
            'pageTitle' => $req['reportType'],
        ]);
    }

}
