<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $lastArticle = $manager->getRepository(Article::class)->findOneBy([], ['id' => 'DESC']);
        $lastId = $lastArticle?->getId() ?? 0;

        for ($i = $lastId+1; $i < $lastId+50; $i++) {
            $article = new Article();
            $article->setTitle("Article " . $i);
            $article->setContent("Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores laudantium quaerat quidem sapiente tempora veniam vero? Alias aliquid animi excepturi, itaque labore, molestiae neque nihil quis rerum saepe suscipit tempora! " . $i);
            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
