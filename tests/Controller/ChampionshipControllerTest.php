<?php

namespace App\Tests\Controller;

use App\Entity\Sport;
use App\Tests\Mother\SportMother;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChampionshipControllerTest extends WebTestCase
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

    public function testPersistChampionshipSuccessfullyReturns201(): void
    {
        $sport = $this->createStandardSport();

        $this->client->jsonRequest('POST', '/api/v1/score/championships', [
            'name' => 'Championship test',
            'dateStart' => new \DateTimeImmutable('now')->format('Y-m-d'),
            'dateEnd' => new \DateTimeImmutable('+ 5 days')->format('Y-m-d'),
            'sportId' => $sport->getId(),
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testSportDoesNotExistReturns404(): void
    {
        $this->client->jsonRequest('POST', '/api/v1/score/championships', [
            'name' => 'Championship test',
            'dateStart' => new \DateTimeImmutable('now')->format('Y-m-d'),
            'dateEnd' => new \DateTimeImmutable('+ 5 days')->format('Y-m-d'),
            'sportId' => PHP_INT_MAX,
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testCreateChampionshipDateEndBeforeDateStartReturns422(): void
    {
        $sport = $this->createStandardSport();

        $this->client->jsonRequest('POST', '/api/v1/score/championships', [
            'name' => 'Championship test',
            'dateStart' => new \DateTimeImmutable('+ 10 days')->format('Y-m-d'),
            'dateEnd' => new \DateTimeImmutable('+ 5 days')->format('Y-m-d'),
            'sportId' => $sport->getId(),
        ]);

        $this->assertResponseStatusCodeSame(422);
    }
}
