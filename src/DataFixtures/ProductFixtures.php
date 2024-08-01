<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Product;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $product = new Product();
            $product->setName($faker->word);
            $product->setDescription($faker->sentence);
            $product->setPrice($faker->randomFloat(2, 10, 100));
            $product->setCreatedAt(new \DateTimeImmutable());
            $product->setImageUrl($faker->imageUrl(640, 480, 'products', true, 'Faker'));
            $product->setSku($faker->unique()->ean8);
            $product->setStockQuantity($faker->numberBetween(0, 100));
            $product->setDiscount($faker->randomFloat(2, 0, 50));
            $product->setCategory($faker->randomElement(['electronique', 'vetements', 'maison', 'sport']));
            $product->setRating($faker->randomFloat(1, 0, 5));
            $product->setNumberOfReviews($faker->numberBetween(0, 100));
            $product->setActive($faker->boolean);
            $product->setFeatured($faker->boolean);
            $product->setNewArrival($faker->boolean);
            $product->setOnPromotion($faker->boolean);

            if ($product->IsOnPromotion()) {
                $promotionStartDate = $faker->dateTimeBetween('-1 month', 'now');
                $promotionEndDate = $faker->dateTimeBetween('now', '+1 month');
                $product->setPromotionStartDate(\DateTimeImmutable::createFromMutable($promotionStartDate));
                $product->setPromotionEndDate(\DateTimeImmutable::createFromMutable($promotionEndDate));
            } else {
                $product->setPromotionStartDate(new \DateTimeImmutable());
                $product->setPromotionEndDate(new \DateTimeImmutable());
            }

            $manager->persist($product);
        }

        $manager->flush();
    }
}

