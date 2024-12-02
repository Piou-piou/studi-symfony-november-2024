<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'article_list')]
    public function list(ArticleRepository $repository): Response
    {
        return $this->render('article/list.html.twig', [
            'articles' => $repository->findAll(),
        ]);
    }


    #[Route('/article/{slug}/{id}', name: 'article_show')]
    //#[IsGranted('show', 'article')]
    public function show(ArticleRepository $repository, string $slug, int $id): Response
    {
        if (!$article = $repository->findOneBySlugQuery($slug, $id)) {
            throw new NotFoundHttpException('Article not found');
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/article/create', name: 'article_create')]
    #[Route('/article/edit/{id}', name: 'article_edit')]
    public function edit(Request $request, EntityManagerInterface $em, ?Article $article)
    {
        if (!$article) {
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Article saved.');

            return $this->redirectToRoute('article_show', [
                'slug' => $article->getSlug(),
                'id' => $article->getId()
            ]);
        }

        return $this->render('article/edit.html.twig', [
            'form' => $form
        ]);
    }
}