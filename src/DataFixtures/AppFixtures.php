<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use function count;
use function rand;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $authors = [];
        for ($i = 0; $i < 100; $i++) {
            $author = new Author();
            $author->setName('Author ' . ($i + 1));

            $manager->persist($author);
            $authors[] = $author;
        }

        $categories = [];
        for ($i = 0; $i < 100; $i++) {
            $category = new Category();
            $category->setName('Category ' . ($i + 1));

            $manager->persist($category);
            $categories[] = $category;
        }

        for ($i = 0; $i < 100; $i++) {
            $book = new Book();
            $book->setTitle('Book ' . ($i + 1));
            $book->setDescription('Book ' . ($i + 1));

            // author
            $book->setAuthor($authors[rand(0, count($authors) - 1)]);

            // categories
            for ($j = 0; $j < rand(1, 5); $j++) {
                $book->addCategory($categories[rand(0, count($categories) - 1)]);
            }

            $manager->persist($book);
        }

        $manager->flush();
    }
}
