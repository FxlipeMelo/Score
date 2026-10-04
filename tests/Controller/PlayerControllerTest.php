<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerControllerTest extends WebTestCase
{
    public function testPersistPlayerSuccessfullyReturns201()
    {
        $client = static::createClient();

        $client->jsonRequest('POST', '/api/v1/score/players', [
            'name' => 'Player 1',
            'birthDate' => '1990-01-01',
            'height' => 1.72,
            'cpf' => '217.965.600-90'
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testCreatePlayerWithBirthDateInvalidReturns422()
    {
        $client = static::createClient();

        $client->jsonRequest('POST', '/api/v1/score/players', [
            'name' => 'Player 1',
            'birthDate' => '2025-01-01',
            'height' => 1.72,
            'cpf' => '217.965.600-90'
        ]);

        $this->assertResponseStatusCodeSame(422);
    }
}
