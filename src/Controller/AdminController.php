<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\TechnoRepository;
use App\Repository\ArticleRepository;
use App\Repository\ContentRepository;
use App\Repository\CommentsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function indexAdmin(): Response
    {
        return $this->render('admin/baseAdmin.html.twig');
    }
    /**
     * @Route("/article", name="article_index", methods={"GET"})
     */
    public function indexArticle(ArticleRepository $articleRepository): Response
    {
        return $this->render('admin/admin_article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/content", name="content_index", methods={"GET"})
     */
    public function indexContent(ContentRepository $contentRepository): Response
    {
        return $this->render('admin/admin_content/index.html.twig', [
            'contents' => $contentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/techno", name="techno_index", methods={"GET"})
     */
    public function indexTechno(TechnoRepository $technoRepository): Response
    {
        return $this->render('admin/admin_techno/index.html.twig', [
            'technos' => $technoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/comments", name="comments_index", methods={"GET"})
     */
    public function indexComments(CommentsRepository $commentsRepository): Response
    {
        return $this->render('admin/admin_comments/index.html.twig', [
            'comments' => $commentsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user", name="user_index", methods={"GET"})
     */
    public function indexUser(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

}