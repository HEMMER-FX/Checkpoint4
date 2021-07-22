<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\CommentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/comments")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminCommentsController extends AbstractController
{
    /**
     * @Route("/", name="admin_comments_index", methods={"GET"})
     */
    public function index(CommentsRepository $commentsRepository): Response
    {
        return $this->render('admin/admin_comments/index.html.twig', [
            'comments' => $commentsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_comments_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $comment = new Comments();
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('admin_comments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_comments/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_comments_show", methods={"GET"})
     */
    public function show(Comments $comment): Response
    {
        return $this->render('admin/admin_comments/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_comments_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Comments $comment): Response
    {
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_comments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_comments/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_comments_delete", methods={"POST"})
     */
    public function delete(Request $request, Comments $comment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin/admin_comments_index', [], Response::HTTP_SEE_OTHER);
    }
}
