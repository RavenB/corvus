<?php

// src/Corvus/AdminBundle/DataFixtures/ORM/LoadUserData.php
namespace Corvus\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager,
    Doctrine\Common\DataFixtures\FixtureInterface,

    Corvus\AdminBundle\Entity\User;


class LoadUserData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$admin = new User();
		$admin->setUsername('admin');
		$admin->setPassword(sha1('password'));

		$manager->persist($admin);
		$manager->flush();
	}
}