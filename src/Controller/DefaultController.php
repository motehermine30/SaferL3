<?php

namespace App\Controller;

use App\Repository\BienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(BienRepository $bienRepo): Response
    {
        $biens = $bienRepo->findBy([],['id'=>'ASC'],3);
        return $this->render('index.html.twig',[
            'biens'=>$biens
        ]);
    }
    #[Route('/admin', name: 'app_admin')]
    public function admin(): Response
    {
        return $this->render('admin/index.html.twig');
    }
    #[Route('/Biens', name: 'app_biens')]
    public function biens(): Response
    {
        return $this->render('pages/biens.html.twig');
    }
}
