<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomepageControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("A Simple Blog by Anil")')->count()
        );
    }

    public function testPostComments() {
        
        $client = static::createClient();
        $db = $client->getContainer()->get('database_connection');

        $postId = $db->fetchColumn( "SELECT id FROM post ORDER BY id DESC LIMIT 1" );

        $client = static::createClient();
        $crawler = $client->request('GET', '/post/'.$postId);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Add Comment')->form(array(
            'form[comment]'  => 'Test comment'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('div:contains("Test comment")')->count(), 'Missing element');
        
    }
}
