<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')] //path
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    
    #[Route('/produit/{var}',name:'test_product')]  // retour avec parametre 
    public function Test($var)
    {
        return new Response("la liste des produits: ".$var); 
    }
 
    #[Route('/show', name: 'show_test')] // retour dans une interface 
    public function ShowProduct()
    {
        return $this->render("test/show.html.twig");
    }
    
    #[Route('reservation', name: 'app_reservation')] //retour sans parametre 
    public function reservation(): Response
    {
        return new Response("La formation");
    }
}


