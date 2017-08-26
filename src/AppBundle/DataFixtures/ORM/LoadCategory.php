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
            'journée'=>1,
            'demi-journée'=>0.5
        );
        foreach ($names as $name=>$coeff)
        {
            $type=new Type();
            $type->setName($name);
            $type->setCoeff($coeff);
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