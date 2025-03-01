<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Entity\Assignment;
use App\Form\GradeType;
use App\Repository\GradeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/grade')]
final class GradeController extends AbstractController
{
    #[Route('/assignment/{id}', name: 'app_grade_index', methods: ['GET'])]
    public function index(Assignment $assignment): Response
    {
        return $this->render('grade/index.html.twig', [
            'grades' => $assignment->getGrades(),
            'assignment' => $assignment
        ]);
    }

    #[Route('/new/assignment/{id}', name: 'app_grade_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Assignment $assignment, EntityManagerInterface $em): Response
    {
        $grade = new Grade();
        $grade->setAssignment($assignment);
    
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($grade);
            $em->flush();
    
            return $this->redirectToRoute('app_grade_index', ['id' => $assignment->getId()]);
        }
    
        return $this->render('grade/new.html.twig', [
            'form' => $form->createView(),
            'assignment' => $assignment
        ]);
    }
    

    #[Route('/edit/{id}', name: 'app_grade_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Grade $grade, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_grade_index', [
                'id' => $grade->getAssignment()->getId()
            ]);
        }

        return $this->render('grade/edit.html.twig', [
            'grade' => $grade,
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'app_grade_delete', methods: ['POST'])]
    public function delete(Request $request, Grade $grade, EntityManagerInterface $em): Response
    {
        $assignmentId = $grade->getAssignment()->getId();
        
        if ($this->isCsrfTokenValid('delete' . $grade->getId(), $request->request->get('_token'))) {
            $em->remove($grade);
            $em->flush();
        }

        return $this->redirectToRoute('app_grade_index', ['id' => $assignmentId]);
    }
}
