<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @var TaskRepository
     */
    private TaskRepository $task_repository;

    public function __construct(
        TaskRepository $task_repository
    ) {
        $this->task_repository = $task_repository;
    }


    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $tasks = $this->task_repository->findAll();

        return $this->render('base.html.twig', ['tasks' => $tasks]);
    }
}
