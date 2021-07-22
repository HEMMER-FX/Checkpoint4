<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/projet")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminProjetController extends AbstractController
{
    /**
     * @Route("/new", name="admin_projet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('admin_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_projet_show", methods={"GET"})
     */
    public function show(Projet $projet): Response
    {
        return $this->render('admin/admin_projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_projet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Projet $projet): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_projet_delete", methods={"POST"})
     */
    public function delete(Request $request, Projet $projet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($projet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin/admin_projet_index', [], Response::HTTP_SEE_OTHER);
    }
}
