<?php

namespace App\Controller;

use App\Entity\Emploi;
use App\Entity\Salles;
use App\Repository\EmploiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\EmploiType;
use App\Form\SallesType;
use App\Repository\SallesRepository;
final class EmploiController extends AbstractController
{
    #[Route('/emploi', name: 'app_emploi')]
    public function index(): Response
    {
        return $this->render('emploi/index.html.twig', [
            'controller_name' => 'EmploiController',
        ]);
    }
    #[Route('/addStatique', name: 'app_addStatique')]
    public function addStatique(EntityManagerInterface $entityManager): Response
    {
        // Créer une instance de l'entité Emploi
        $emploi1 = new Emploi();
        $emploi1->setJour("Vendredi");
        $emploi1->setHrDeb(new \DateTime("2024-02-28 07:00:00"));
        $emploi1->setHrFin(new \DateTime("2024-02-28 08:00:00"));
        // Enregistrer l'entité dans la base de données
        $entityManager->persist($emploi1);
        $entityManager->flush();
        return $this->redirectToRoute('app_show_emploi');
    }
    
    #[Route('/show_emploi', name: 'app_show_emploi')]
    public function show(EmploiRepository $repoemploi): Response
    {
        $list=$repoemploi->findAll();
        return $this->render('emploi/show.html.twig', [
            'emplois'=>$list
        ]);
    }


    #[Route('/Add_emploi', name: 'app_add_emploi')]
    public function Add( Request $request , EntityManagerInterface $em)
    {
        $emploi=new Emploi();
        $form = $this->createForm(EmploiType::class, $emploi);
        $form-> add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
          
            $Salles = $emploi->getSalle();

            if ($Salles instanceof Salles) {
                $Salles->getNom();
            }
            
        $em ->persist($emploi);
        $em ->flush();
        return $this->redirectToRoute('app_show_emploi');
        
        }
        return $this->render('emploi/Add.html.twig', ['f'=>$form ->createView()]);
    }

    #[Route('/editemp/{id}', name:'app_edit_emp')]
    public function edit(EmploiRepository $repository,$id, Request $request, EntityManagerInterface $em ): Response
    {
        $emploi= $repository ->find($id) ;
        $form=$this->CreateForm(EmploiType::class,$emploi);
        $form->add('Edit',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('app_show_emploi');
        }
        return $this->render('Emploi/edit.html.twig',['e'=>$form->createView()]);

    }
    #[Route('/deleteemp/{id}', name:'app_delete_emp')]
    public function delete(EmploiRepository $repository,$id, EntityManagerInterface $em ): Response
    {
        $emploi= $repository ->find($id) ;
        if(!$emploi)
        {
            throw $this-> createNotFoundException('date  non trouvé');
        }
            $em-> remove($emploi);
            $em->flush();
            return $this->redirectToRoute('app_show_emploi');
    }

}
