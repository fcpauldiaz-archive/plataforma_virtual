<?php

namespace CursoBundle\Tests\Controller;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CursoControllerTest extends WebTestCase
{
    /**
     * This method tests the UI of crear curso.
     *
     * @author  pablo diaz <fcpauldiaz@gmail.com>
     */
    public function testCreateCurso()
    {
        // Create a new client to browse the application
        $client = static::createAuthorizedClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/admin/curso/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /curso/');

        $crawler = $client->click($crawler->selectLink('Crear Nuevo Curso')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'appbundle_curso[nombreCurso]' => 'Test',
            'appbundle_curso[codigoCurso]' => 'Test4',
            // ... other fields to fill
        ));

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Editar')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'appbundle_curso[nombreCurso]' => 'Foo',
            'appbundle_curso[codigoCurso]' => 'Foo1',
            // ... other fields to fill
        ));

        $client->submit($form);
        //
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
        var_dump($client->getResponse()->getContent());
    }
    /**
     * Close doctrine connections to avoid having a 'too many connections'
     * message when running many tests
     * Sirve para eliminar la entidad de prueba creada.
     */
    public function tearDown()
    {
        //$this->getContainer()->get('doctrine')->getConnection()->close();
        parent::tearDown();
    }

    /**
     * Este método sirve para autenticar el cliente y poder utilizar la aplicación como un usuario.
     *
     * @return Client
     */
    protected function createAuthorizedClient()
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $session = $container->get('session');
        /** @var $userManager \FOS\UserBundle\Doctrine\UserManager */
        $userManager = $container->get('fos_user.user_manager');
        /** @var $loginManager \FOS\UserBundle\Security\LoginManager */
        $loginManager = $container->get('fos_user.security.login_manager');
        $firewallName = $container->getParameter('fos_user.firewall_name');

        $user = $userManager->findUserBy(array('username' => 'admin'));
        $loginManager->loginUser($firewallName, $user);

        // save the login token into the session and put it in a cookie
        $container->get('session')->set('_security_'.$firewallName,
            serialize($container->get('security.context')->getToken()));
        $container->get('session')->save();
        $client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));

        return $client;
    }
}
