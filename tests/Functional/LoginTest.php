<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testSuccessfulLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $form = $crawler->filter('#form-login')->form();
        $form['_username'] = 'test@gmail.com';
        $form['_password'] = $_ENV['TEST_USER_PASSWORD'];
        $client->submit($form);

        $this->assertRouteSame('app_login');
        $client->followRedirect();
        $this->assertRouteSame('app_home_index');
        $this->assertSelectorTextContains('div', 'adaline.jakubowski');
    }

    public function testUnsuccessfulLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $form = $crawler->filter('#form-login')->form();
        $username = 'test@gmail.com';
        $form['_username'] = $username;
        $form['_password'] = 'null';
        $client->submit($form);

        $this->assertRouteSame('app_login');
        $client->followRedirect();
        $this->assertResponseRedirects("/?error=failed&lastUsername=$username");
    }
}
