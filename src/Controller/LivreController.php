<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LivreController extends AbstractController
{
    /**
     * @Route("/", name="livre.index")
     */
    public function index(): Response
    {
        return $this->render('livre/index.html.twig');
    }
    /**
     * @Route("/livre/list", name="livre.list")
     */
    public function list(LivreRepository $livreRepository): Response
    {
        $livres = $livreRepository->findAll();
        return $this->render('livre/list.html.twig', compact('livres'));
    }
    /**
     * @Route("/livre/create", name="livre.create")
     */
    public function create(Request $request,LivreRepository $livreRepository ): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ){
            $livreRepository->add($livre, true);

            $this->addFlash("success", "Le livre a été ajouté à la liste avec succès.");

            return $this->redirectToRoute('livre.list');
        }

        return $this->renderForm('livre/create.html.twig', [
            "form"=> $form
        ]);
    }
    /**
     * @Route("/livre/edit/{id<\d+>}", name="livre.edit")
     */
    public function edit(Livre $livre, Request $request, LivreRepository $livreRepository)
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {
            $livreRepository->add($livre, true);

            $this->addFlash("success", "Le livre a été modifié avec succès.");

            return $this->redirectToRoute('livre.list');
        }

        return $this->renderForm('livre/edit.html.twig', array(
            'livre' => $livre,
            "form" => $form
        ));
    }
    /**
     * @Route("/livre/delete/{id<\d+>}", name="livre.delete")
     */
    public function delete(Livre $livre, Request $request, LivreRepository $livreRepository)
    {
        if( $this->isCsrfTokenValid("delete_livre_" . $livre->getId() , $request->request->get('_token')))
        {
            $livreRepository->remove($livre, true);
            $this->addFlash("success", $livre->getTitre() . " a été supprimé.");
        }
        
        return $this->redirectToRoute('livre.list');
    }
}
