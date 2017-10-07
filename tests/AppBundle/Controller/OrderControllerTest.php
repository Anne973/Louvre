<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    //checks that all the URLS load successfully
    public function urlProvider()
    {
        return [
            ['/fr/selection_step_one',200],
            ['/fr/selection_step_two',302],
            ['/fr/ticket',302],
        ];
    }

    /**
     * @dataProvider urlProvider
     */
    public function testUrls($url, $exceptedStatus)
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $url);
        $this->assertSame($exceptedStatus, $client->getResponse()->getStatusCode());
    }

    //check the number of tickets
    public function testStepOne()
    {
        $client = static::createClient();


        $crawler = $client->request('GET', '/fr/selection_step_one');

        $step_one_form = $crawler->selectButton('Save')->form();

        $client->submit($step_one_form, array(
            'order_step_one[date][day]'=> '28',
            'order_step_one[date][month]'=> '12',
            'order_step_one[date][year]'=> '2017',
            'order_step_one[type]'=> '62',
            'order_step_one[adresse]'=>'anne.derenoncourt@gmail.com',
            'order_step_one[number]'=>'1',

        ));

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('form h3')->count());



        $step_two_form=$crawler->selectButton('Save')->form();

        $client->submit($step_two_form, array(
            'order_step_two[tickets][0][lastname]' => 'derenoncourt',
            'order_step_two[tickets][0][firstname]' => 'anne',
            'order_step_two[tickets][0][country]' =>'FR',
            'order_step_two[tickets][0][birthdate][day]' =>'12',
            'order_step_two[tickets][0][birthdate][month]' =>'4',
            'order_step_two[tickets][0][birthdate][year]' =>'1976'
        ));

        $crawler = $client->followRedirect();

        $this->assertSame(2, $crawler->filter('p:contains("16 euros")')->count());

    }


}
