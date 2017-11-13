<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Employees;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $employee = new Employees();
            $employee->setName('Employee '.$i);
            $employee->setLogin('employee_'.$i);
            $manager->persist($employee);
        }

        $manager->flush();
    }
}