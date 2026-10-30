<?php

namespace App\Tests\Controller;

use App\Entity\Player;
use App\Entity\Team;
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

    private function createStandardTeam(): Team
    {
        $sport = SportMother::create();
        $team = TeamMother::create(sport: $sport);
        $this->entityManager->persist($sport);
        $this->entityManager->persist($team);
        $this->entityManager->flush();

        return $team;
    }

    private function createStandardPlayer(): Player
    {
        $player = PlayerMother::create();
        $this->entityManager->persist($player);
        $this->entityManager->flush();

        return $player;
    }



    public function testTeamRosterSuccessfullyReturn201(): void
    {
        $team = $this->createStandardTeam();
        $player = $this->createStandardPlayer();

        $this->client->jsonRequest('POST', '/api/v1/score/teams/' . $team->getId() . '/players', [
            'shirtNumber' => 10,
            'playerID' => $player->getId(),
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testReturn404WhenTeamDoesNotExist(): void
    {
        $player = $this->createStandardPlayer();

        $this->client->jsonRequest('POST', '/api/v1/score/teams/' . PHP_INT_MAX . '/players', [
            'shirtNumber' => 10,
            'playerID' => $player->getId(),
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testReturn404WhenPlayerDoesNotExist(): void
    {
        $team = $this->createStandardTeam();

        $this->client->jsonRequest('POST', '/api/v1/score/teams/' . $team->getId() . '/players', [
            'shirtNumber' => 10,
            'playerID' => PHP_INT_MAX,
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testCannotAddSamePlayersTwiceReturn409(): void
    {
        $team = $this->createStandardTeam();
        $player = $this->createStandardPlayer();

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

    public function testCannotAddTwoPlayersWithSameShirtNumberReturn409(): void
    {
        $team = $this->createStandardTeam();
        $player = $this->createStandardPlayer();
        $player2 = $this->createStandardPlayer();

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
