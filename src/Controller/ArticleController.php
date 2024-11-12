<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ArticleController extends AbstractController
{
    #[Route('/article/create', name: 'article_create')]
    #[Route('/article/edit/{id}', name: 'article_edit')]
    public function edit(EntityManagerInterface $em, ?Article $article)
    {
        if (!$article) {
            $article = new Article();
            $article->setTitle('Mon nouvel article');
            $article->setContent('Lorem ipsum');
            $em->persist($article);
            $em->flush();
        } else {
            $article->setTitle('Mon nouvel article rename2');
            $em->persist($article);
            $em->flush();
        }

        return $this->redirectToRoute('article_show', [
            'slug' => $article->getSlug(),
            'id' => $article->getId(),
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
}