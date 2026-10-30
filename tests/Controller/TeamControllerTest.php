<?php

namespace App\Tests\Controller;

use App\Entity\Sport;
use App\Tests\Mother\SportMother;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TeamControllerTest extends WebTestCase
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

    public function testPersistTeamSuccessfullyReturns201(): void
    {
        $sport = $this->createStandardSport();

        $this->client->jsonRequest('POST', '/api/v1/score/teams', [
            'name' => 'Team test',
            'sportId' => $sport->getId(),
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testSportDoesNotExistReturns404(): void
    {
        $this->client->jsonRequest('POST', '/api/v1/score/teams', [
            'name' => 'Team test',
            'sportId' => PHP_INT_MAX,
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testCannotPersistTeamNameIsBlankReturns422(): void
    {
        $sport = $this->createStandardSport();

        $this->client->jsonRequest('POST', '/api/v1/score/teams', [
            'name' => '',
            'sportId' => $sport->getId(),
        ]);

        $this->assertResponseStatusCodeSame(422);
    }
}
