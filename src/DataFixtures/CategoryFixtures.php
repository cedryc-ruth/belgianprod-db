<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;


class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            ['name' => 'Aventure'],
            ['name' => 'Comédie'],
            ['name' => 'Romance'],
            ['name' => 'Horreur'],
            ['name' => 'Action'],
            ['name' => 'Science-Fiction'],
            ['name' => 'Suspense']
        ];

        foreach($data as $row) {
            $category = new Category();
            $category->setName($row['name']);

            $this->addReference($row['name'], $category);
            
            $manager->persist($category);
        }

        $manager->flush();
    }
}
