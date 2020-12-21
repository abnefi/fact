<?php

namespace ConfigBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConfigRaisonRejetControllerTest extends WebTestCase
{
    public function testSendraison()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/sendRaison');
    }

}
