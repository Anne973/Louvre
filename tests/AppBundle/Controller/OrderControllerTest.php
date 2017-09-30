<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    //checks that all the URLS load successfully
    public function urlProvider()
    {
        return array(

            array('/fr/selection_step_one'),
            array('/fr/selection_step_two'),
            array('/fr/ticket'),
            array('/fr/checkout/{stripe}'),
        );
    }

    //check the number of tickets
    public function testStepOne()
    {
        $client = static::createClient();

        $client->followRedirects();

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


        $this->assertSame(1, $crawler->filter('form h3')->count());



       /* $step_two_form=$crawler->selectButton('Save')->form();

        $client->submit($step_two_form, array(
            'order_step_two[tickets][0][lastname]' => 'derenoncourt',
            'order_step_two[tickets][0][firstname]' => 'anne',
            'order_step_two[tickets][0][country]' =>'France',
            'order_step_two[tickets][0][birthdate][day]' =>'12',
            'order_step_two[tickets][0][birthdate][month]' =>'04',
            'order_step_two[tickets][0][birthdate][year]' =>'1976',
            'order_step_two[tickets][0][reduced]'=>'false',


        ));*/

    }


}
