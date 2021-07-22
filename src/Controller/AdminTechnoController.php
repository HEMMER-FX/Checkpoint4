<?php

namespace App\Controller;

use App\Entity\Techno;
use App\Form\TechnoType;
use App\Repository\TechnoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/techno")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminTechnoController extends AbstractController
{
    /**
     * @Route("/new", name="admin_techno_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $techno = new Techno();
        $form = $this->createForm(TechnoType::class, $techno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($techno);
            $entityManager->flush();

            return $this->redirectToRoute('admin_techno_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_techno/new.html.twig', [
            'techno' => $techno,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_techno_show", methods={"GET"})
     */
    public function show(Techno $techno): Response
    {
        return $this->render('admin/admin_techno/show.html.twig', [
            'techno' => $techno,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_techno_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Techno $techno): Response
    {
        $form = $this->createForm(TechnoType::class, $techno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_techno_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_techno/edit.html.twig', [
            'techno' => $techno,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_techno_delete", methods={"POST"})
     */
    public function delete(Request $request, Techno $techno): Response
    {
        if ($this->isCsrfTokenValid('delete'.$techno->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($techno);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_techno_index', [], Response::HTTP_SEE_OTHER);
    }
}
