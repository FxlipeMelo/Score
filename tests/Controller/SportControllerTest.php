<?php

namespace App\Tests\Controller;

use App\Enum\MatchType;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SportControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    public function testPersistSportSuccessfullyReturns201(): void
    {
        $this->client->jsonRequest('POST', '/api/v1/score/sports', [
            'name' => uniqid('Sport_', true),
            'maxPlayerPerTeam' => 11,
            'matchType' => MatchType::TIME->value
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testCannotAddSportIdentifiedWithAnotherSportReturns409(): void
    {
        $this->client->jsonRequest('POST', '/api/v1/score/sports', [
            'name' => 'Sport',
            'maxPlayerPerTeam' => 11,
            'matchType' => MatchType::TIME->value
        ]);

        $this->client->jsonRequest('POST', '/api/v1/score/sports', [
            'name' => 'Sport',
            'maxPlayerPerTeam' => 11,
            'matchType' => MatchType::TIME->value
        ]);

        $this->assertResponseStatusCodeSame(409);
    }

    public function testCannotAddMaxPlayerPerTeamNegativeOrZeroReturns422(): void
    {
        $this->client->jsonRequest('POST', '/api/v1/score/sports', [
            'name' => uniqid('Sport_', true),
            'maxPlayerPerTeam' => 0,
            'matchType' => MatchType::TIME->value
        ]);

        $this->assertResponseStatusCodeSame(422);
    }
}

