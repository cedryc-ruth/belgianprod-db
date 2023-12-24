<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Movie;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            array(
                'title' => 'Blade Runner',
                'description' => 'Sci-fi noir movie.',
                'duration' => '117',
                'director' => 'Ridley Scott',
                'slug' => 'blade-runner',
                'category_name' => 'Science-Fiction',
                'actor_firstname' => 'Bob',
                'actor_lastname' => 'Sull'
            ),
            array(
                'title' => 'Die Hard',
                'description' => 'Action movie in a tower.',
                'duration' => '132',
                'director' => 'John McTiernan',
                'slug' => 'die-hard',
                'category_name' => 'Action',
                'actor_firstname' => 'Clara',
                'actor_lastname' => 'Smills'
            ),
            array(
                'title' => 'Blade Runner',
                'description' => 'Sci-fi noir movie.',
                'duration' => '117',
                'director' => 'Ridley Scott',
                'slug' => 'blade-runner',
                'category_name' => 'Science-Fiction',
                'actor_firstname' => 'Clara',
                'actor_lastname' => 'Smills'
            )
        ];

        foreach($data as $row) {
            try {
                $movie = $this->getReference($row['slug']);
            } catch(\Exception $e) {
                $movie = null;
            }

            if(is_null($movie)) {
                $movie = new Movie();
                $movie->setTitle($row['title']);
                $movie->setDescription($row['description']);
                $movie->setDuration($row['duration']);
                $movie->setDirector($row['director']);
                $movie->setSlug($row['slug']);
            
                $movie->setCategory($this->getReference($row['category_name']));

                $this->addReference($row['slug'], $movie);
            }

            $movie->addActor($this->getReference("{$row['actor_firstname']}-{$row['actor_lastname']}"));

            $manager->persist($movie);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
