<?php

namespace App\Controller;
use App\Repository\StudentRepository ; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use App\Entity\Student;
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
    public function liststudent(StudentRepository $repository)
    {
        $students=$repository->findAll(); 
        return $this->render('student/liststudent.html.twig',array('tabstudent'=>$students)) ; 
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
        if ($form->isSubmitted()){
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
}
