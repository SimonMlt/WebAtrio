<?php

namespace App\Controller;

use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Personne;
use App\Form\PersonneType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class PersonneController extends AbstractController
{
    #[Route('/personne', 'personne.index', methods: ['GET'])]
    public function index(PersonneRepository $repository): Response
    {
        $personnes = $repository->findBy(array(), array('nom' => 'ASC', 'prenom' => 'ASC'));

        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
            
        ]);
    }

    #[Route('/personne/new', 'personne.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager) : Response
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $personne = $form->getData();
            $manager->persist($personne);
            $manager->flush();

            $this->addFlash(
                'success',
                'Personne insérée avec succès !'
            );

            return $this->redirectToRoute('personne.index');
        }
        
        return $this->render('personne/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
