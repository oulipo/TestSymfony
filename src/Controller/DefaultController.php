<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Date;

class DefaultController extends Controller
{
    /**
     * @Route("/default", name="default")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    public function accueil() {
        return $this->render('default/accueil.html.twig',[
            'texte' => 'lorem ipsum',
            'titre' => 'test',
            'tableau' => [1,2,3,4,5],
            //'date' => new \Date("now")

        ] );
    }

    public function faq() {
        return $this->render('default/faq.html.twig');
    }

    public function design() {
        return $this->render('default/design.html.twig');
    }


}
