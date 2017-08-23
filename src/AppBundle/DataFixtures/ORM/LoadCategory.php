<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Type;

class LoadCategory implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names=array(
            'journée',
            'demi-journée'
        );
        foreach ($names as $name)
        {
            $type=new Type();
            $type->setName($name);

            $manager->persist($type);
        }
        $manager->flush();
    }
}
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 23/08/2017
 * Time: 09:29
 */