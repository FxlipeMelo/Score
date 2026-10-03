<?php

namespace App\Tests\Controller;

use App\Repository\SportRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChampionshipControllerTest extends WebTestCase
{
    public function testPersistChampionshipSuccessfullyReturns201(): void
    {
        $client = static::createClient();
        $sportRepository = static::getContainer()->get(SportRepository::class);
        $sport = $sportRepository->findOneBy(['name' => 'Sport 0']);

        $client->jsonRequest('POST', '/api/v1/score/championships', [
            'name' => 'Championship test',
            'dateStart' => '2020-01-01',
            'dateEnd' => '2020-01-02',
            'sportId' => $sport->getId(),
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testSportDoesNotExistReturns404()
    {
        $client = static::createClient();

        $client->jsonRequest('POST', '/api/v1/score/championships', [
            'name' => 'Championship test',
            'dateStart' => '2020-01-01',
            'dateEnd' => '2020-01-02',
            'sportId' => 99999
        ]);

        $this->assertResponseStatusCodeSame(404);
    }
}
