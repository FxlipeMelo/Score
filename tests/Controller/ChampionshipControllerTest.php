<?php

namespace App\Tests\Controller;

use App\Entity\Sport;
use App\Enum\MatchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChampionshipControllerTest extends WebTestCase
{
    public function testPersistChampionship(): void
    {
        $client = static::createClient();
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $sport = new Sport('Futsal', 15, MatchType::TIME);
        $entityManager->persist($sport);
        $entityManager->flush();

        $client->jsonRequest('POST', '/api/v1/score/championships', [
            'name' => 'Championship test',
            'dateStart' => '2020-01-01',
            'dateEnd' => '2020-01-02',
            'sportId' => $sport->getId(),
        ]);

        $this->assertResponseStatusCodeSame(201);
    }
}
