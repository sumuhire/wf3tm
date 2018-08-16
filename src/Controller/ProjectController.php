<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Project;
use App\Form\ProjectFormType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Document;

class ProjectController extends Controller
{
    public function listProjects(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        
        $project = new Project();
        $projectForm = $this->createForm(ProjectFormType::class, $project, ['standalone' => true]);
        
        $projectForm->handleRequest($request);
        if ($projectForm->isSubmitted() && $projectForm->isValid()) {
            
            $file = $project->getThumbnailsss();
            //Move file
            if($file){
                $document = new Document();
                $document->setPath($this->getParameter('upload_dir'))
                    ->setMimeType($file->getMimeType())
                    ->setName($file->getFilename());
            

                //move the file at the end
                $file->move($this->getParameter('upload_dir'));
                
                $project->setThumbnailsss($document);

                $manager->persist($document);
            }
            //Insert data
            $manager->persist($project);
            $manager->flush();
            
            return $this->redirectToRoute('project_list');
        }
        
        return $this->render(
            'Project/list.html.twig',
            [
                'projects' => $manager->getRepository(Project::class)->findAll(),
                'projectForm' => $projectForm->createView()
            ]
        );
    }
}

