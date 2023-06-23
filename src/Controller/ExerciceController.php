<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExerciceController extends AbstractController
{
   #[route('/exercice', name : 'exercice')]
   public function index(): Response
   {
     $tableau = [902, 527, 65, 215, 815, 802, 80];
     $max = max($tableau);
     $min = min($tableau);
     $nbrval = count($tableau);

       return $this->render('exercice/exercice.html.twig', [
           'tableau' => $tableau,
           'max' => $max,
           'min' => $min,
           'nbrval' => $nbrval,
       ]);
   }
    
    
 
}
