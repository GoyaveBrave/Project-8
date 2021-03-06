<?php

namespace App\Controller;

use App\Entity\Task;
use App\Service\TaskManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskCreateController extends AbstractController
{

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(TaskManager $taskManager, Request $request)
    {
        $user = $this->getUser();
        $task = new Task();

        $form = $taskManager->form($task, $request);

        if ($form->isSubmitted() && $form->isValid()) {

            $taskManager->create($task, $user);

            $this->addFlash('success', 'La tâche a été bien été créée !');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}