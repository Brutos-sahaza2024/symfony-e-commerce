<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Faq;
use App\Entity\ImageAcceuil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProductFixtures extends Fixture
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $images = [
            [
                'title' => 'E-commerce Hero Image',
                'description' => 'A hero image representing e-commerce solutions.',
                'source' => 'https://www.ssi-schaefer.com/resource/blob/1179526/b5bdadcababc0904a574ea9d675870c3/e-commerce-hero-dam-image-en-31561--data.jpg',
            ],
            [
                'title' => 'E-commerce Image',
                'description' => 'A general image related to e-commerce.',
                'source' => 'https://www.ionos.fr/digitalguide/fileadmin/DigitalGuide/Teaser/e-commerce.jpg',
            ],
            [
                'title' => 'E-commerce Graphic',
                'description' => 'A graphic representing e-commerce concepts.',
                'source' => 'https://www.lopinion.ma/photo/art/grande/80036925-57845592.jpg?v=1714923714',
            ],
            [
                'title' => 'E-commerce ',
                'description' => 'A png representing e-commerce concepts.',
                'source' => 'https://doers.ma/wp-content/uploads/2023/08/E-commerce-au-Maroc.png',
            ],
        ];
;
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

        foreach ($images as $imageData) {
            $image = new ImageAcceuil();
            $image->setTitle($imageData['title']);
            $image->setDescription($imageData['description']);
            $image->setSource($imageData['source']);

            $manager->persist($image);
        }

        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setUsername('superadmin');
        $user->setRoles(['ROLE_SUPER_ADMIN']);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'securepassword'
        );
        $user->setPassword($hashedPassword);

        $manager->persist($user);


        $categoryData = [
            "maison",
            "sport", 
            "mode",
            "electronique"
        ];
        
        foreach ($categoryData as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
        
            $manager->persist($category);
        }

        $faqs = [
            [
                'question' => 'Comment suivre ma commande ?',
                'answer' => 'Vous pouvez suivre votre commande en utilisant le numéro de suivi fourni dans l\'e-mail de confirmation de commande. Vous pouvez également vous connecter à votre compte pour voir le statut de vos commandes récentes.'
            ],
            [
                'question' => 'Quelle est la politique de retour ?',
                'answer' => 'Nous acceptons les retours dans les 30 jours suivant la réception de votre commande. Pour initier un retour, veuillez vous rendre sur la page de retours et suivre les instructions.'
            ],
            [
                'question' => 'Comment puis-je contacter le support technique ?',
                'answer' => 'Si vous rencontrez des problèmes techniques sur notre site, veuillez d\'abord essayer de vider le cache de votre navigateur et de vous reconnecter. Si le problème persiste, contactez notre équipe technique.'
            ],
            // Ajoutez d'autres FAQ ici
        ];

        foreach ($faqs as $faqData) {
            $faq = new Faq();
            $faq->setQuestion($faqData['question']);
            $faq->setAnswer($faqData['answer']);
            $manager->persist($faq);
        }
        

        $manager->flush();
    }
}

