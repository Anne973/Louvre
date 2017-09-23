<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    //checks that all the URLS load successfully
    public function urlProvider()
    {
        return array(
            array('/{_locale}/selection_step_one'),
            array('/{_locale}/selection_step_two'),
            array('/{_locale}/ticket'),
            array('/{_locale}/checkout/{stripe}'),
        );
    }

    //check the number of tickets
    public function testStepOne()
    {
        $client = static::createClient();

        $crawler=$client->request('GET', '/{_locale}/selection_step_one');

        $form=$crawler->selectButton('Save')->form();

        $client->submit($form, array(
            'date'=> '09/25/2017',
            'type'=>'journée',
            'adresse'=>'anne.derenoncourt@gmail.com',
            'number'=>'2',

        ));

        $crawler=$client->followRedirect();

        $this->assertSame(2, $crawler->filter('form')->count());;

    }
}
