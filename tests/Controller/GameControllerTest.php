<?php

namespace App\Tests\Controller;

use App\Entity\Championship;
use App\Entity\Registration;
use App\Entity\Sport;
use App\Entity\Team;
use App\Tests\Mother\ChampionshipMother;
use App\Tests\Mother\RegistrationMother;
use App\Tests\Mother\SportMother;
use App\Tests\Mother\TeamMother;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameControllerTest extends WebTestCase
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

    private function createStandardRegistration(Team $team, Championship $championship): Registration
    {
        $registration = RegistrationMother::create(team: $team, championship: $championship);
        $this->entityManager->persist($registration);
        $this->entityManager->flush();

        return $registration;
    }

    public function testPersistGameSuccessfullyReturns201(): void
    {
        $sport = $this->createStandardSport();
        $teamHome = $this->createStandardTeam($sport);
        $teamAway = $this->createStandardTeam($sport);
        $championship = $this->createStandardChampionship($sport);
        $registrationHome = $this->createStandardRegistration($teamHome, $championship);
        $registrationAway = $this->createStandardRegistration($teamAway, $championship);

        $this->client->jsonRequest('POST', '/api/v1/score/games', [
            'homeRegistrationId' => $registrationHome->getId(),
            'awayRegistrationId' => $registrationAway->getId(),
            'dateGame' => '2026-12-25 17:00:00'
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testCannotCreateGameRegistrationNotFoundReturns404(): void
    {
        $sport = $this->createStandardSport();
        $teamHome = $this->createStandardTeam($sport);
        $championship = $this->createStandardChampionship($sport);
        $registrationHome = $this->createStandardRegistration($teamHome, $championship);

        $this->client->jsonRequest('POST', '/api/v1/score/games', [
            'homeRegistrationId' => $registrationHome->getId(),
            'awayRegistrationId' => PHP_INT_MAX,
            'dateGame' => '2026-12-25 17:00:00'
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testCannotCreateGameHomeTeamIsRegisteredDifferentChampionshipThanTheAwayTeamReturns422(): void
    {
        $sport = $this->createStandardSport();
        $teamHome = $this->createStandardTeam($sport);
        $teamAway = $this->createStandardTeam($sport);
        $championship = $this->createStandardChampionship($sport);
        $championship2 = $this->createStandardChampionship($sport);
        $registrationHome = $this->createStandardRegistration($teamHome, $championship);
        $registrationAway = $this->createStandardRegistration($teamAway, $championship2);

        $this->client->jsonRequest('POST', '/api/v1/score/games', [
            'homeRegistrationId' => $registrationHome->getId(),
            'awayRegistrationId' => $registrationAway->getId(),
            'dateGame' => '2026-12-25 17:00:00',
        ]);

        $this->assertResponseStatusCodeSame(422);
    }

    public function testCannotCreateGameWithSameRegistrationReturns422(): void
    {
        $sport = $this->createStandardSport();
        $team = $this->createStandardTeam($sport);
        $championship = $this->createStandardChampionship($sport);
        $registration = $this->createStandardRegistration($team, $championship);

        $this->client->jsonRequest('POST', '/api/v1/score/games', [
            'homeRegistrationId' => $registration->getId(),
            'awayRegistrationId' => $registration->getId(),
            'dateGame' => '2026-12-25 17:00:00',
        ]);

        $this->assertResponseStatusCodeSame(422);
    }
}
