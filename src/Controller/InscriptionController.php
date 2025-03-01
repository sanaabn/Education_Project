<?php
namespace App\Controller;


use App\Entity\Inscription;
use App\Entity\Utilisateur;
use App\Form\InscripType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



final class InscriptionController extends AbstractController 
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(): Response
    {
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }

    #[Route('/register', name: 'app_register')]
public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
{
    $inscription = new Inscription();
    $form = $this->createForm(InscripType::class, $inscription);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      
        $utilisateur = new Utilisateur();
        $utilisateur->setNom($form->get('nom')->getData());
        $utilisateur->setEmail($form->get('email')->getData());
        $utilisateur->setType($form->get('type')->getData());
        $utilisateur->setNiveau($form->get('niveau')->getData());
        $utilisateur->setMatiere($form->get('matiere')->getData());
        $hashedPassword = $passwordHasher->hashPassword($utilisateur, $form->get('password')->getData());
        $utilisateur->setPassword($hashedPassword);
    

       
        $inscription->setUtilisateur($utilisateur);

        
        $entityManager->persist($utilisateur);
        $entityManager->persist($inscription);
        $entityManager->flush();

   
        return $this->redirectToRoute('inscription_success');
    }

   
    return $this->render('inscription/register.html.twig', [
        'form' => $form->createView(),
    ]);
}

    #[Route('/inscription/success', name: 'inscription_success')]
    public function success(): Response
    {
        return $this->render('inscription/login.html.twig');
    }

   


#[Route('/login', name: 'app_login')]
public function login(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
{
   
    $email = $request->request->get('email');  
    $password = $request->request->get('password');  
 
    if (null === $email || null === $password) {
        return $this->render('inscription/login.html.twig', [
            'error' => 'Email or password is missing',
        ]);
    }

    
    $utilisateur = $entityManager->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);

    if (!$utilisateur) {
        
        return $this->render('inscription/login.html.twig', [
            'error' => 'Email not found',
        ]);
    }

  
    if (!$passwordHasher->isPasswordValid($utilisateur, $password)) {
       
        return $this->render('inscription/login.html.twig', [
            'error' => 'Invalid password',
        ]);
    }

 
    return $this->redirectToRoute('app_utilisateur');
}

}
