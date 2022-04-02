<?php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 1; $i++) {
            $user = new User();
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setRoles(['USER_ROLE']);
            $user->setEmail($faker->email);
            $user->setAddress($faker->address);
            $user->setCity($faker->city);
            $user->setBirthDate($faker->dateTime);
            $user->setPassword($this->encoder->encodePassword($user, "motdepasse"));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
