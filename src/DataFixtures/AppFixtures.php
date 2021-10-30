<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Faker\Factory;
use App\Entity\Product;
use App\Entity\User;
use Bezhanov\Faker\Provider\Commerce;
use Bluemmb\Faker\PicsumPhotosProvider;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
        $faker->addProvider(new \Bluemmb\Faker\PicsumPhotosProvider($faker));

        $categoryColor = ["success", "danger", "warning", "info", "dark"];

        for ($c=0; $c <= 4; $c++) 
        { 
            $category = new Category();
            $category->setName($faker->department())
                ->setColor($categoryColor[$c]);
            
            $manager->persist($category);
        
            for ($p=1; $p <= 10; $p++) 
            { 
                $product = new Product();

                $product->setName($faker->productName())
                    ->setShortDescription($faker->sentence(20))
                    ->setLongDescription($faker->paragraph(50))
                    ->setPrice($faker->randomFloat(2, 10, 300))
                    ->setQuantity($faker->numberBetween(1, 50))
                    ->setVisible($faker->boolean())
                    ->setCreatedAt($faker->dateTimeThisYear())
                    ->setMainPicture($faker->imageUrl(300, 300, true))
                    ->setCategory($category)
                    ->setUpdatedAt($product->getCreatedAt());

                $manager->persist($product);
            }
        }

        $admin = new User();

        $hash = $this->hasher->hashPassword($admin, "password");

        $admin->setEmail("admin@mail.com")
            ->setPassword($hash)
            ->setRoles(['ROLE_ADMIN'])
            ->setFullName("Admin")
            ->setActive(true);

        $manager->persist($admin);

        $userCity = ["Paris","Lyon","Marseille","Bourg-en-Bresse","Bordeaux"];

        for ($u=0; $u <= 4 ; $u++) 
        { 
            $user = new User();

            $hash = $this->hasher->hashPassword($user, "password");

            $nb = $u + 1;

            $user->setEmail("user$nb@mail.com")
                ->setPassword($hash)
                ->setRoles([]) 
                ->setFullName($faker->name()) 
                ->setAddress($faker->streetAddress())
                ->setZipCode($faker->postcode())
                ->setCity($userCity[$u])
                ->setCountry("France")
                ->setPhoneNumber($faker->phoneNumber());

            $manager->persist($user);
        }
        
        $manager->flush();
    }
}
