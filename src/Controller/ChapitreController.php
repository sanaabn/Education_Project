<?php

namespace App\Controller;
use App\Entity\Chapitre;
use App\Form\ChapitreType;
use App\Entity\Matiere;
use App\Form\MatiereType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MatiereRepository;
use App\Repository\ChapitreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

final class ChapitreController extends AbstractController
{
    #[Route('/chapitre', name: 'app_chapitre')]
    public function index(): Response
    {
        return $this->render('chapitre/index.html.twig', [
            'controller_name' => 'ChapitreController',
        ]);
    }


    #[Route('/affichechap', name: 'app_affichechap')]

    public function read(ChapitreRepository $repochapitre): Response

    {$list=$repochapitre->findAll();

        return $this->render('chapitre/Showchapitre.html.twig', [

            'Chapitres' => $list

        ]);

    }


    #[Route('/Addchapitre', name:'app_Addchapitre')]
    public function Add(Request $request, EntityManagerInterface $em ): Response
    {
        $chapitre=new Chapitre();
        $form=$this->CreateForm(ChapitreType::class,$chapitre);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            
            $matiere=$chapitre->getNomMatiere();
            if($matiere instanceof Matiere)
            { 
                $matiere->addNbrChapitre($chapitre);  
                $em->persist($chapitre);
                $em->persist($matiere);  
                $em->flush(); 
            }
            return $this->redirectToRoute('app_affichechap');
        }
        return $this->render('chapitre/Addchapitre.html.twig',['c'=>$form->createView()]);

    }

    #[Route('/editchapitre/{id}', name:'app_editchapitre')]
    public function edit(ChapitreRepository $repository,$id, Request $request, EntityManagerInterface $em ): Response
    {
        $chapitre= $repository ->find($id) ;
        $form=$this->CreateForm(ChapitreType::class,$chapitre);
        $form->add('Edit',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('app_affichechap');
        }
        return $this->render('chapitre/Editchapitre.html.twig',['ch'=>$form->createView()]);

    }
    #[Route('/deletechapitre/{id}', name:'app_deletechapitre')]
    public function delete(ChapitreRepository $repository,$id, EntityManagerInterface $em ): Response
    {
        $chapitre= $repository ->find($id) ;
        if(!$chapitre)
        {
            throw $this-> createNotFoundException('chapitre non trouvé');
        }
            $em-> remove($chapitre);
            $em->flush();
            return $this->redirectToRoute('app_affichechap');
    }
    


}
