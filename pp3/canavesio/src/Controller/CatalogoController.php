<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CatalogoController extends AbstractController
{
    #[Route('/catalogo', name: 'app_catalogo')]
    public function index(): Response
    {
        return $this->render('catalogo/index.html.twig', [
            'controller_name' => 'CatalogoController',
        ]);
    }
}
