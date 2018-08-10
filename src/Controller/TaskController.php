<?php

namespace App\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\TaskFormType;
use App\DTO\TaskSearch;
use App\Form\TaskSearchFormType;

class TaskController extends Controller
{
    
    public function listTasks(Request $request)
    {
        //Create an instance of doctrine manager that will register data
        $manager = $this->getDoctrine()->getManager();
        //Instance the la class task
        $task = new Task();
        //Créer un formulaire
        $form = $this->createForm(TaskFormType::class, $task, ['standalone' => true]);
        
        //Envoie la requete de création d'un formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Register data if validated form
            $manager->persist($task);
            $manager->flush();
            
            //redirect to route task list when information registered
            return $this->redirectToRoute('task_list');
        }
        
        //

        $dto = new TaskSearch();
        $searchForm = $this->createForm(TaskSearchFormType::class, $dto, ['standalone' => true]);
        
        $searchForm->handleRequest($request);
        
            $tasks = $manager->getRepository(Task::class)
                ->findByTaskSearch($dto);
      
    

        //



        return $this->render(
                'task/list.html.twig',
                [
                    'tasks' =>  $tasks,
                    'form' => $form->createView(),
                    'searchForm' => $searchForm->createView()
                ]
            );
    }
    //using attribute in the route change our structure
    // public function taskDetail(Request $request)
    //when we can doctrine in the function, symfony knows we are referring to doctrine(id voir template(getId)) and automatically get
    public function taskDetail(Task $task, Request $request)
    {
        // $id = $request->query->get('id');
        
        // if (!$id) {
        //     throw new NotFoundHttpException();
        // }
        
        // $task = $this->getDoctrine()
        //     ->getManager()
        //     ->getRepository(Task::class)
        //     ->find($id);
        // ;
        // if (!isset($task)) {
        //     throw new NotFoundHttpException();
        // }
        
        //task is set as default
        $form = $this->createForm(TaskFormType::class, $task, ['standalone' => true]);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //Id we create new information we have to persist, if we got information form the manager no need
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(
                'task_detail',
                [
                    'task' => $task -> getId()
                ]
            );
        }

        //Display a task for a particular project
        return $this->render(
                'task/detail.html.twig',
                [
                    'task' => $task,
                    'form' => $form->createView()
                ]
            );
    }
}
