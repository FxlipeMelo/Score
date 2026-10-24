<?php

namespace App\Tests\Controller;

use App\Entity\Sport;
use App\Enum\MatchType;
use App\Tests\Mother\SportMother;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SportControllerTest extends WebTestCase
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

    public function testPersistSportSuccessfullyReturns201()
    {
        $this->client->JsonRequest('POST', '/api/v1/score/sports', [
            'name' => uniqid('Sport_', true),
            'maxPlayerPerTeam' => 11,
            'matchType' => MatchType::TIME->value
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testCannotAddSportIdentifiedWithAnotherSportReturns409()
    {
        $this->client->JsonRequest('POST', '/api/v1/score/sports', [
            'name' => 'Sport',
            'maxPlayerPerTeam' => 11,
            'matchType' => MatchType::TIME->value
        ]);

        $this->client->JsonRequest('POST', '/api/v1/score/sports', [
            'name' => 'Sport',
            'maxPlayerPerTeam' => 11,
            'matchType' => MatchType::TIME->value
        ]);

        $this->assertResponseStatusCodeSame(409);
    }

    public function testCannotAddMaxPlayerPerTeamNegativeOrZeroReturns422()
    {
        $this->client->JsonRequest('POST', '/api/v1/score/sports', [
            'name' => uniqid('Sport_', true),
            'maxPlayerPerTeam' => 0,
            'matchType' => MatchType::TIME->value
        ]);

        $this->assertResponseStatusCodeSame(422);
    }
}

