<?php

namespace App\Tests\Controller;

use App\Repository\ChampionshipRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testEnrollsTeamSuccessfullyReturns201()
    {
        $client = static::createClient();
        $teamRepository = static::getContainer()->get(TeamRepository::class);
        $championshipRepository = static::getContainer()->get(ChampionshipRepository::class);
        $team = $teamRepository->findOneBy(['name' => 'Team 0']);
        $championship = $championshipRepository->findOneBy(['name' => 'Championship 0']);

        $client->jsonRequest('POST', '/api/v1/score/championships/' . $championship->getId() . '/registrations', [
            'teamId' => $team->getId(),
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testReturns404WhenChampionshipDoesNotExist()
    {
        $client = static::createClient();
        $teamRepository = static::getContainer()->get(TeamRepository::class);
        $team = $teamRepository->findOneBy(['name' => 'Team 0']);

        $client->jsonRequest('POST', '/api/v1/score/championships/' . 99999 . '/registrations', [
            'teamId' => $team->getId(),
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testRegisterTeamWithDifferentSportThanChampionshipReturns400()
    {
        $client = static::createClient();
        $teamRepository = static::getContainer()->get(TeamRepository::class);
        $championshipRepository = static::getContainer()->get(ChampionshipRepository::class);
        $team = $teamRepository->findOneBy(['name' => 'Team 0']);
        $championship = $championshipRepository->findOneBy(['name' => 'Championship 1']);

        $client->jsonRequest('POST', '/api/v1/score/championships/' . $championship->getId() . '/registrations', [
            'teamId' => $team->getId(),
        ]);

        $this->assertResponseStatusCodeSame(400);
    }
}
