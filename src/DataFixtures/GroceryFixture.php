<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Grocery;
use App\Enum\GrocerySource;
use App\Enum\GroceryType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class GroceryFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $grocery1 = new Grocery(
            'Banana',
            GroceryType::FRUIT,
            5,
            GrocerySource::API,
        );

        $grocery2 = new Grocery(
            'Carrot',
            GroceryType::VEGETABLE,
            3,
            GrocerySource::JSON_FILE_IMPORT,
        );

        $manager->persist($grocery1);
        $manager->persist($grocery2);

        $manager->flush();
    }
}
