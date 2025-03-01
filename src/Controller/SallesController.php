<?php

namespace App\Controller;


use App\Form\SallesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Salles;
use App\Repository\SallesRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;


final class SallesController extends AbstractController
{
    #[Route('/salles', name: 'app_salles')]
    public function index(): Response
    {
        return $this->render('salles/index.html.twig', [
            'controller_name' => 'SallesController',
        ]);
    }

   /* #[Route('/addStatique', name: 'app_addStatique')]
    public function addStatique(EntityManagerInterface $entityManager): Response
    {
        // Créer une instance de l'entité Salle
        $Salle = new Salles();
        $Salle->setNom("SL12");
        $Salle->setCapacite(30);
        $Salle->setType("LABO");
        $Salle->setDisponibilite("true");

        // Enregistrer l'entité dans la base de données
        $entityManager->persist($Salle);
        $entityManager->flush();
        return $this->redirectToRoute('app_show_Salle');
    }*/
    
    #[Route('/show_Salle', name: 'app_show_Salle')]
    public function show(SallesRepository $repoSalle): Response
    {
        $list=$repoSalle->findAll();
        return $this->render('Salles/show.html.twig', [
            'Salles'=>$list
        ]);
    }

    #[Route('/Add_Salle', name: 'app_add')]
    public function Add( Request $request , EntityManagerInterface $em)
    {
        $Salle=new Salles();
        $form = $this->createForm(SallesType::class, $Salle);
        $form-> add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        $em ->persist($Salle);
        $em ->flush();
        return $this->redirectToRoute('app_show_Salle');
        
        }
        return $this->render('Salles/Add.html.twig', ['s'=>$form ->createView()]);
    }
    
    #[Route('/edit/{id}', name:'app_edit')]
    public function edit(SallesRepository $repository,$id, Request $request, EntityManagerInterface $em ): Response
    {
        $Salle= $repository ->find($id) ;
        $form=$this->CreateForm(SallesType::class,$Salle);
        $form->add('Edit',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('app_show_Salle');
        }
        return $this->render('Salles/edit.html.twig',['e'=>$form->createView()]);

    }
    #[Route('/delete/{id}', name:'app_delete')]
    public function delete(SallesRepository $repository,$id, EntityManagerInterface $em ): Response
    {
        $Salle= $repository ->find($id) ;
        if(!$Salle)
        {
            throw $this-> createNotFoundException('salle non trouvé');
        }
            $em-> remove($Salle);
            $em->flush();
            return $this->redirectToRoute('app_show_Salle');
    }
}
