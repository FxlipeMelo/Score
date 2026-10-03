<?php

namespace App\Tests\Controller;

use App\Repository\SportRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TeamControllerTest extends WebTestCase
{
    public function testPersistTeamSuccessfullyReturns201()
    {
        $client = static::createClient();
        $sportRepository = $client->getContainer()->get(SportRepository::class);
        $sport = $sportRepository->findOneBy(['name' => 'Sport 0']);

        $client->jsonRequest('POST', '/api/v1/score/teams', [
            'name' => 'Team test',
            'sportId' => $sport->getId(),
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testSportDoesNotExistReturns404()
    {
        $client = static::createClient();

        $client->jsonRequest('POST', '/api/v1/score/teams', [
            'name' => 'Team test',
            'sportId' => 99999,
        ]);

        $this->assertResponseStatusCodeSame(404);
    }
}
