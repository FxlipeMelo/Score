<?php

namespace App\Tests\Controller;

use App\Entity\Championship;
use App\Entity\Sport;
use App\Entity\Team;
use App\Enum\MatchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testEnrollsTeamSuccessfullyReturns201()
    {
        $client = static::createClient();
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $sport = new Sport('Futsal', 15, MatchType::TIME);
        $championship = new Championship('Championship test', new \DateTimeImmutable('02-02-2022'), new \DateTimeImmutable('02-04-2022'), $sport);
        $team = new Team('Team test', $sport);
        $entityManager->persist($sport);
        $entityManager->persist($championship);
        $entityManager->persist($team);
        $entityManager->flush();

        $client->jsonRequest('POST', '/api/v1/score/championships/' . $championship->getId() . '/registrations', [
            'teamId' => $team->getId(),
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testReturns404WhenChampionshipDoesNotExist()
    {
        $client = static::createClient();
        $sport = new Sport('Futsal', 15, MatchType::TIME);
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $team = new Team('Team test', $sport);
        $entityManager->persist($sport);
        $entityManager->persist($team);
        $entityManager->flush();

        $client->jsonRequest('POST', '/api/v1/score/championships/' . 99999 . '/registrations', [
            'teamId' => $team->getId(),
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testRegisterTeamWithDifferentSportThanChampionshipReturns400()
    {
        $client = static::createClient();
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $sport1 = new Sport('Futsal', 15, MatchType::TIME);
        $sport2 = new Sport('Volei de praia', 3, MatchType::SET);
        $team = new Team('Team test', $sport1);
        $championship = new Championship('Championship test', new \DateTimeImmutable('02-02-2022'), new \DateTimeImmutable('02-04-2022'), $sport2);
        $entityManager->persist($sport1);
        $entityManager->persist($sport2);
        $entityManager->persist($team);
        $entityManager->persist($championship);
        $entityManager->flush();

        $client->jsonRequest('POST', '/api/v1/score/championships/' . $championship->getId() . '/registrations', [
            'teamId' => $team->getId(),
        ]);

        $this->assertResponseStatusCodeSame(400);
    }
}
