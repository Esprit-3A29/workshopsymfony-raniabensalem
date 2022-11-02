<?php

namespace App\Controller;
use App\Repository\StudentRepository ; 
use App\Repository\ClassroomRepository ; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use App\Entity\Student;
use App\Form\SearchStudentType;
use App\Form\StudentType;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\Request;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    #[Route('/Students', name: 'list_student')]
    public function liststudent(StudentRepository $repository,Request $request)
    {
        $students=$repository->findAll(); 
        $sortBymoyenne= $repository->sortBymoyenne() ; //afficher avec tri
        $formSearch= $this->createForm(SearchStudentType::class); 
        $formSearch->handleRequest($request);
        $topStudents= $repository->toppStudent();  // le meilleur eleves 
        if($formSearch->isSubmitted()){
            $nce= $formSearch->get('nce')->getData();
            //var_dump($nce).die();
            $result= $repository->searchStudent($nce);     // recherche
            return $this->renderForm("student/liststudent.html.twig",
                array("tabstudent"=>$result,
                    "sortBymoyenne"=>$sortBymoyenne,
                    "searchForm"=>$formSearch,'topStudents'=>$topStudents));
        }
          return $this->renderForm("student/liststudent.html.twig",
            array("tabstudent"=>$students,
                "sortBymoyenne"=>$sortBymoyenne,
                 "searchForm"=>$formSearch,
                'topStudents'=>$topStudents));

    }
    #[Route('/addFormStudent', name: 'add')]
    public function addForm(ManagerRegistry $doctrine,Request $request, StudentRepository $repository)
    {
        $student= new Student ;
        $form= $this->createForm(StudentType::class,$student);
        $form->handleRequest($request) ;
        if ($form->isSubmitted())
        {
              $repository->add($student,True) ; 
             return  $this->redirectToRoute("list_student");
         }
        return $this->renderForm("student/add.html.twig",array("formStudent"=>$form));
    }


    #[Route('/updateFormStudent/{nce}', name: 'update2')]
    public function  updateForm($nce,StudentRepository $repository,ManagerRegistry $doctrine,Request $request)
    {
        $student= $repository->find($nce);       
        $form= $this->createForm(StudentType::class,$student);     
        $form->handleRequest($request) ;          
        if ($form->isSubmitted()
        ){     
            $em= $doctrine->getManager();
            $em->flush();
            return  $this->redirectToRoute("list_student");
        }
        return $this->renderForm("student/update.html.twig",array("formStudent"=>$form));
    }

    #[Route('/removeFormStudent/{nce}', name: 'remove2')]

    public function removeStudent(ManagerRegistry $doctrine,$nce,StudentRepository $repository)
    {
        $student= $repository->find($nce);
        $em = $doctrine->getManager();
        $em->remove($student);
        $em->flush();
        return  $this->redirectToRoute("list_student");
}
#[Route('/showClassroom/{id}', name: 'showClassroom')]
public function showClassroom(StudentRepository $repo,$id,ClassroomRepository $repository)
{
    $classroom = $repository->find($id);
   $students= $repo->getStudentsByClassroom($id);
    return $this->render("student/showClassroom.html.twig",array(
        'showClassroom'=>$classroom,
        'tabStudent'=>$students
    ));
}
}
