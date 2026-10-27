<?php

namespace App\Tests\Controller;

use App\Entity\Championship;
use App\Entity\Sport;
use App\Entity\Team;
use App\Tests\Mother\ChampionshipMother;
use App\Tests\Mother\SportMother;
use App\Tests\Mother\TeamMother;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
    }

    private function createStandardSport(): Sport
    {
        $sport = SportMother::create();
        $this->entityManager->persist($sport);
        $this->entityManager->flush();

        return $sport;
    }

    private function createStandardTeam(Sport $sport): Team
    {
        $team = TeamMother::create(sport: $sport);
        $this->entityManager->persist($team);
        $this->entityManager->flush();

        return $team;
    }

    private function createStandardChampionship(Sport $sport): Championship
    {
        $championship = ChampionshipMother::create(sport: $sport);
        $this->entityManager->persist($championship);
        $this->entityManager->flush();

        return $championship;
    }

    public function testEnrollsTeamSuccessfullyReturns201(): void
    {
        $sport = $this->createStandardSport();
        $team = $this->createStandardTeam($sport);
        $championship = $this->createStandardChampionship($sport);

        $this->client->jsonRequest('POST', '/api/v1/score/championships/' . $championship->getId() . '/registrations', [
            'teamId' => $team->getId(),
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testReturns404WhenChampionshipDoesNotExist(): void
    {
        $sport = $this->createStandardSport();
        $team = $this->createStandardTeam($sport);

        $this->client->jsonRequest('POST', '/api/v1/score/championships/' . PHP_INT_MAX . '/registrations', [
            'teamId' => $team->getId(),
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testRegisterTeamWithDifferentSportThanChampionshipReturns400(): void
    {
        $sport1 = $this->createStandardSport();
        $sport2 = $this->createStandardSport();
        $team = $this->createStandardTeam($sport1);
        $championship = $this->createStandardChampionship($sport2);


        $this->client->jsonRequest('POST', '/api/v1/score/championships/' . $championship->getId() . '/registrations', [
            'teamId' => $team->getId(),
        ]);

        $this->assertResponseStatusCodeSame(400);
    }
}
