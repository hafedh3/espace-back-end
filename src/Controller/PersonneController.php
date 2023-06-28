<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    #[Route('/personne/add', name: 'add_personne')]
    public function addPersonne(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine-> getManager();
        $personne = new Personne();
        $personne->setFirstname('Hafedh');
        $personne->setLastname('Ben Dhia');
        $personne->setAge(28);
        $personne-> setDatedenaissance(new \DateTime('1995-06-03'));

        $entityManager->persist($personne);
        $entityManager->flush();

        return $this->render('personne/index.html.twig', [
            'personne' => $personne,
        ]);
    }



    #[Route('/personne/liste', name: 'liste_personnes')]
    public function listePersonnes(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine-> getRepository(Personne::class);
        $personnes= $repository->findAll();
    
        return $this->render('personne/liste.html.twig', [
            'personnes' => $personnes,
        ]);
    }


    
    #[Route('/personne/{id<\d+>}', name: 'get_personne')]
    public function getPersonneById(ManagerRegistry $doctrine, $id): Response
    {
        $repository = $doctrine-> getRepository(Personne::class);
        $personne= $repository->find($id);

        if(!$personne)
        {
            $this->addFlash('error', "La personne d'id $id n'existe pas ");
           
        }
    
        return $this->render('personne/personne.html.twig', [
            'personne' => $personne,
        ]);
    }



    #[Route('/personne/delete/{id<\d+>}', name: 'delete_personne')]
    public function deletePersonne(ManagerRegistry $doctrine, $id): RedirectResponse
    {
        $repository = $doctrine-> getRepository(Personne::class);
        $personne= $repository->find($id);

        if($personne)
        {
            $manager = $doctrine->getManager();
            $manager->remove($personne);
            $manager->flush();

            $this->addFlash('succes', "La personne d'id $id a été supprimé avec succes ");
           
        }
        else{
            $this->addFlash('succes', "La personne d'id $id n'exsite pas ");

        }
    
        return $this->redirectToRoute('liste_personnes');
    }


    #[Route('/personne/update/{id}', name: 'update_personne')]
    public function updatePersonne(Request $request, ManagerRegistry $doctrine, $id): Response
    {
        $manager = $doctrine->getManager();
        $personne = $manager->getRepository(Personne::class)->find($id);

        if (!$personne) {
            throw $this->createNotFoundException('Personne non trouvée');
        }

        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'La personne a été mise à jour avec succès.');

            return $this->redirectToRoute('liste_personnes');
        }

        return $this->render('personne/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}




