<?php

namespace App\Controller;
use App\Entity\Matiere;
use App\Form\MatiereType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MatiereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

final class MatiereController extends AbstractController
{
    #[Route('/matiere', name: 'app_matiere')]
    public function index(): Response
    {
        return $this->render('matiere/index.html.twig', [
            'controller_name' => 'MatiereController',
        ]);
    }

    #[Route('/Show_matiere', name: 'Afficher-Matiere')]

    public function Show(MatiereRepository $repomatiere): Response

    {$list=$repomatiere->findAll();

        return $this->render('matiere/Show.html.twig', [

            'Matieres' => $list

        ]);

    }

    #[Route('/AddStatistique1', name: 'app_AddStatistique1')]

    public function addStatistique(EntityManagerInterface $entityManager): Response

    {
        //crée une instance de l'entité author
        $matiere1 = new Matiere();
        $matiere1-> setnom("TechnologieWeb");
        $matiere1->setcoeficient(4);
        $matiere1->setNombreDesHeures(30);
        $matiere1->setModeDevaluation("examen et cc");
        $entityManager->persist($matiere1);
        $entityManager->flush();
        return $this->redirectToRoute('Afficher-Matiere');
    }

    #[Route('/Addmatiere', name:'app_Addmatiere')]
    public function Add(Request $request, EntityManagerInterface $em ): Response
    {
        $matiere=new Matiere();
        $form=$this->CreateForm(MatiereType::class,$matiere);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($matiere);
            $em->flush();
            return $this->redirectToRoute('Afficher-Matiere');
        }
        return $this->render('matiere/Add.html.twig',['m'=>$form->createView()]);

    }

    #[Route('/editmatiere/{id}', name:'app_editmatiere')]
    public function edit(MatiereRepository $repository,$id, Request $request, EntityManagerInterface $em ): Response
    {
        $matiere= $repository ->find($id) ;
        $form=$this->CreateForm(MatiereType::class,$matiere);
        $form->add('Edit',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('Afficher-Matiere');
        }
        return $this->render('matiere/edit.html.twig',['e'=>$form->createView()]);

    }
    #[Route('/deletematiere/{id}', name:'app_deletematiere')]
    public function delete(MatiereRepository $repository,$id, EntityManagerInterface $em ): Response
    {
        $matiere= $repository ->find($id) ;
        if(!$matiere)
        {
            throw $this-> createNotFoundException('matiere non trouvé');
        }
            $em-> remove($matiere);
            $em->flush();
            return $this->redirectToRoute('Afficher-Matiere');
    }
    

    
}

