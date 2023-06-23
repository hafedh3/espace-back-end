<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{

      #[Route('/', name: 'acceuil')]
    public function indexx(): Response
    {
        return new response (
            "<head>

            <title>
            ma premier page
            </title>
            <h1>Hello Hafedh</h1>
            </head>"
        );
    }


    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig', [
            'controller_name' => 'FirstController',
        ]);
    }


    #[Route('/hello/{name}', name: 'hello')]
    public function index3($name):Response
    {
        return $this->render('first/index.html.twig', [
            'nom' => $name,
        ]);
    
    }
}
