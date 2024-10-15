<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;
use App\Entity\Article;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i <= 10; $i++) {
            $article = new Article();
            $article->setName($faker->word());
            $article->setDescription($faker->text());
            $article->setPrice($faker->randomFloat(2, 0, 999999.99));
            $article->setImage('1656001927_bb633eb9d4e4e96ba1ab.png');
            $manager->persist($article);
        }
        
        $manager->flush();
    }
}
