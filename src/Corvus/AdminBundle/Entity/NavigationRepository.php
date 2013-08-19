<?php

// src/Corvus/AdminBundle/Entity/NavigationRepository.php
namespace Corvus\AdminBundle\Entity;

use Doctrine\ORM\EntityManager,

    Corvus\AdminBundle\ILP\ORM\Repository\BaseEntityRepository;


class NavigationRepository extends BaseEntityRepository
{
    public function __construct(EntityManager $em)
    {
        $this->_entityName = Navigation::getRepoName();
        parent::__construct($em);
    }
}