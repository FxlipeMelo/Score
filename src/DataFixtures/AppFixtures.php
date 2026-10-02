<?php

namespace App\DataFixtures;

use App\Entity\Championship;
use App\Entity\Sport;
use App\Entity\Team;
use App\Enum\MatchType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 3; $i++) {
            $sport = new Sport('Sport ' . $i, 2 + $i, MatchType::TIME);
            $team = new Team('Team ' . $i, $sport);
            $championship = new Championship('Championship ' . $i, new \DateTimeImmutable('01-01-2026'), new \DateTimeImmutable('01-12-2026'), $sport);
            $manager->persist($sport);
            $manager->persist($team);
            $manager->persist($championship);
        }

        $manager->flush();
    }
}
