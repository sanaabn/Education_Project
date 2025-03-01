<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Utilisateur;
use App\Form\UserType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }


    #[Route('/utilisateur/show', name: 'afficher_utilisateur')]
    public function show(UtilisateurRepository $repo): Response
    {
        $list = $repo->findAll();
        return $this->render('utilisateur/show.html.twig', [
            'utilisateurs' => $list
        ]);
    }

    #[Route('/utilisateur/add_static', name: 'add_utilisateur_static')]
    public function addStatic(EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher): Response
    {

       
        $utilisateur = new Utilisateur();
        $utilisateur->setNom("Test User");
        $utilisateur->setEmail("testuser@example.com");
        $hashedPassword = $passwordHasher->hashPassword($utilisateur, "Lavieenrose");
        $utilisateur->setPassword($hashedPassword);
        $utilisateur->setType("etudiant");
        $utilisateur->setNiveau("3eme");
        $utilisateur->setMatiere("");
        
       

        $entityManager->persist($utilisateur);
        $entityManager->flush();

        return $this->redirectToRoute('afficher_utilisateur');
    }

    #[Route('/utilisateur/add', name: 'add_utilisateur')]
    public function add(Request $request, EntityManagerInterface $em,UserPasswordHasherInterface $passwordHasher): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UserType::class, $utilisateur);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          
            $hashedPassword = $passwordHasher->hashPassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($hashedPassword);
    
            $em->persist($utilisateur);
            $em->flush();
            
            return $this->redirectToRoute('afficher_utilisateur');
        }
    

        return $this->render('utilisateur/add.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/utilisateur/edit/{id}', name: 'edit_utilisateur')]
    public function edit(UtilisateurRepository $repository, $id, Request $request, EntityManagerInterface $em): Response
    {
        $utilisateur = $repository->find($id);
        $form = $this->createForm(UserType::class, $utilisateur);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('afficher_utilisateur');
        }

        return $this->render('utilisateur/edit.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/utilisateur/delete/{id}', name: 'delete_utilisateur')]
    public function delete(UtilisateurRepository $repository, $id, EntityManagerInterface $em): Response
    {
        $utilisateur = $repository->find($id);
        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $em->remove($utilisateur);
        $em->flush();

        return $this->redirectToRoute('afficher_utilisateur');
    }

    
}







    

