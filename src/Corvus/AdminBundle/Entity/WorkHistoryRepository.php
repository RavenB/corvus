<?php

namespace Corvus\AdminBundle\Entity;

use Doctrine\ORM\EntityManager,

    Corvus\AdminBundle\ILP\ORM\Repository\BaseEntityRepository;

class WorkHistoryRepository extends BaseEntityRepository
{
    public function __construct(EntityManager $em)
    {
            $this->_entityName = WorkHistory::getRepoName();
            parent::__construct($em);
    }
}