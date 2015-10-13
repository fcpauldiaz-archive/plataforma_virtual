<?php

namespace CursoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        //var_dump($client->getResponse()->getContent());
        $this->assertTrue($crawler->filter('html:contains("homepage")')->count() > 0);
    }
}
