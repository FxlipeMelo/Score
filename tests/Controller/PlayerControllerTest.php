<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    public function testPersistPlayerSuccessfullyReturns201(): void
    {
        $this->client->jsonRequest('POST', '/api/v1/score/players', [
            'name' => 'Player 1',
            'birthDate' => '1990-01-01',
            'height' => 1.72,
            'cpf' => '217.965.600-90'
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testCreatePlayerWithBirthDateInvalidReturns422(): void
    {
        $this->client->jsonRequest('POST', '/api/v1/score/players', [
            'name' => 'Player 1',
            'birthDate' => new \DateTimeImmutable('- 5 years - 11 months - 29 days')->format('Y-m-d'),
            'height' => 1.72,
            'cpf' => '217.965.600-90'
        ]);

        $this->assertResponseStatusCodeSame(422);
    }

    public function testAddPlayerWithCPFInvalidReturns422(): void
    {
        $this->client->jsonRequest('POST', '/api/v1/score/players', [
            'name' => 'Player 1',
            'birthDate' => '1990-01-01',
            'height' => 1.72,
            'cpf' => '111.111.111-11'
        ]);

        $this->assertResponseStatusCodeSame(422);
    }
}
