<?php

namespace App\Controller;

use App\Entity\Content;
use App\Form\ContentType;
use App\Repository\ContentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/content")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminContentController extends AbstractController
{
    /**
     * @Route("/new", name="admin_content_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $content = new Content();
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($content);
            $entityManager->flush();

            return $this->redirectToRoute('admin_content_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_content/new.html.twig', [
            'content' => $content,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_content_show", methods={"GET"})
     */
    public function show(Content $content): Response
    {
        return $this->render('admin/admin_content/show.html.twig', [
            'content' => $content,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_content_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Content $content): Response
    {
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_content_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_content/edit.html.twig', [
            'content' => $content,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_content_delete", methods={"POST"})
     */
    public function delete(Request $request, Content $content): Response
    {
        if ($this->isCsrfTokenValid('delete'.$content->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($content);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin/admin_content_index', [], Response::HTTP_SEE_OTHER);
    }
}
