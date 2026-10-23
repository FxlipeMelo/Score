<?php

namespace App\Tests\Controller;

use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use App\Tests\Mother\PlayerMother;
use App\Tests\Mother\SportMother;
use App\Tests\Mother\TeamMother;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TeamRosterControllerTest extends WebTestCase
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

    private function createStandardTeamAndPlayer(): array
    {
        $sport = SportMother::create();
        $team = TeamMother::create(sport: $sport);
        $player = PlayerMother::create();
        $this->entityManager->persist($sport);
        $this->entityManager->persist($team);
        $this->entityManager->persist($player);
        $this->entityManager->flush();

        return [$team, $player];
    }

    public function testTeamRosterSuccessfullyReturn201()
    {
        [$team, $player] = $this->createStandardTeamAndPlayer();

        $this->client->jsonRequest('POST', '/api/v1/score/teams/' . $team->getId() . '/players', [
            'shirtNumber' => 10,
            'playerID' => $player->getId(),
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testReturn404WhenTeamDoesNotExist()
    {
        [, $player] = $this->createStandardTeamAndPlayer();

        $this->client->jsonRequest('POST', '/api/v1/score/teams/' . 999999 . '/players', [
            'shirtNumber' => 10,
            'playerID' => $player->getId(),
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testReturn404WhenPlayerDoesNotExist()
    {
        [$team, ] = $this->createStandardTeamAndPlayer();

        $this->client->jsonRequest('POST', '/api/v1/score/teams/' . $team->getId() . '/players', [
            'shirtNumber' => 10,
            'playerID' => 999999,
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testCannotAddSamePlayersTwiceReturn409()
    {
        [$team, $player] = $this->createStandardTeamAndPlayer();

        $this->client->jsonRequest('POST', '/api/v1/score/teams/' . $team->getId() . '/players', [
            'shirtNumber' => 10,
            'playerID' => $player->getId(),
        ]);

        $this->client->jsonRequest('POST', '/api/v1/score/teams/' . $team->getId() . '/players', [
            'shirtNumber' => 14,
            'playerID' => $player->getId(),
        ]);

        $this->assertResponseStatusCodeSame(409);
    }

    public function testCannotAddTwoPlayersWithSameShirtNumberReturn409()
    {
        [$team, $player] = $this->createStandardTeamAndPlayer();
        $player2 = PlayerMother::create();
        $this->entityManager->persist($player2);
        $this->entityManager->flush();

        $this->client->jsonRequest('POST', '/api/v1/score/teams/' . $team->getId() . '/players', [
            'shirtNumber' => 10,
            'playerID' => $player->getId(),
        ]);

        $this->client->jsonRequest('POST', '/api/v1/score/teams/' . $team->getId() . '/players', [
            'shirtNumber' => 10,
            'playerID' => $player2->getId(),
        ]);

        $this->assertResponseStatusCodeSame(409);
    }
}
