<?php

namespace App\Tests\Controller;

use App\Entity\Sport;
use App\Enum\MatchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TeamControllerTest extends WebTestCase
{
    public function testPersistTeam(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get(EntityManagerInterface::class);
        $sport =  new Sport('Futsal', 15, MatchType::TIME);
        $entityManager->persist($sport);
        $entityManager->flush();

        $client->jsonRequest('POST', '/api/v1/score/teams', [
            'name' => 'Team test',
            'sportId' => $sport->getId(),
        ]);

        $this->assertResponseStatusCodeSame(201);

    }
}
