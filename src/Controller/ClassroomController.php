<?php

namespace App\Controller;
use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository ; 
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Component\HttpFoundation\Request;


class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
#---------------------------- afficher------------------------------    #

    #[Route('/classrooms', name: 'list_classroom')]
    public function listclassroom(ClassroomRepository $repository)
    {
        $classroom=$repository->findAll(); 
        return $this->render('classroom/classroom.html.twig',array('tabclassroom'=>$classroom)) ; 
    }
#--------------------------ajout sans formulaire --------------------#
    #[Route('/addStudent', name: 'add_student')]
    public function addstudent(ManagerRegistry $doctrine)
    {
        $classroom= new Classroom();
        $classroom->setName("rahma");
        $classroom->setDescription("vjcghfj");
       // $em=$this->getDoctrine()->getManager();
        $em= $doctrine->getManager();
        $em->persist($classroom);
        $em->flush();
        return $this->redirectToRoute("list_student");
    }
# --------------------------- ajouter avec formulaire ---------#   

     #[Route('/addForm', name: 'add2')]
    public function addForm(ManagerRegistry $doctrine,Request $request)
    {
        $classroom= new Classroom;
        $form= $this->createForm(ClassroomType::class,$classroom);
        $form->handleRequest($request) ;   // Pour traiter les données du formulaire 
      
        if ($form->isSubmitted())
        {
             $em= $doctrine->getManager(); // pour faire ajout dans la base de donnée 
             $em->persist($classroom); // t7adher requete teina
             $em->flush(); // mise a jour o tzidha 
           // $repository->add($classroom,True) ; 
             return  $this->redirectToRoute("list_classroom");
         }
        return $this->renderForm("classroom/add.html.twig",array("formClassroom"=>$form));
    }
# ------------------------------modification-----------------#

    #[Route('/updateForm/{id}', name: 'update')]
    public function  updateForm($id,ClassroomRepository $repository,ManagerRegistry $doctrine,Request $request)
    {
        $classroom= $repository->find($id); //recuperer l'objet par id 
        $form= $this->createForm(ClassroomType::class,$classroom);
        $form->handleRequest($request) ;
        if ($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->flush();
            return  $this->redirectToRoute("list_classroom");
        }
        return $this->renderForm("classroom/update.html.twig",array("formClassroom"=>$form));
    }
#---------------------- supprimer ---------------------------------------#

    #[Route('/removeForm/{id}', name: 'remove')]
public function removeClassroom(ManagerRegistry $doctrine,$id,ClassroomRepository $repository)
    {
        $classroom= $repository->find($id);
        $em = $doctrine->getManager();
        $em->remove($classroom);
        $em->flush(); //mise a jour 
        return  $this->redirectToRoute("list_classroom");
    }
   
}
