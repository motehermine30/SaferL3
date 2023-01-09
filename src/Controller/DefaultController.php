<?php

namespace App\Controller;

use App\Entity\Bien;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\BienRepository;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface; 
use Symfony\Component\HttpFoundation\Request; 

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
    public function biens(BienRepository $bienRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $data = $bienRepository->findBy([],['created_at' => 'desc']);
        $biens = $paginator->paginate(
            $data, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );
        return $this->render('pages/biens.html.twig',[
            'current_menu'=>'bien',
            'biens' => $biens,
        ]);
    }

    #[Route('/Biens/{slug}-{id}', name: 'bien_show', methods: ['GET'], requirements:["slug" => "[a-z0-9\-]*"])]
    public function show(Bien $bien, string $slug): Response
    {
        if ($bien->getSlug() !== $slug) {
           return $this->redirectToRoute('bien_show',['id'=>$bien->getId(),'slug'=>$bien->getSlug()],301);
        }
        return $this->render('pages/show.html.twig', [
            'current_menu'=>'bien',
            'bien' => $bien,
        ]);
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function contact(Request $request, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->save($contact, true);
            $this->addFlash('success','Message envoye avec success');
            return $this->redirectToRoute('app_contact', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/contact.html.twig', [
            'form' => $form,
            'current_menu'=>'bien',

        ]);
    }
    
}
