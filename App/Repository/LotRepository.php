<?php

namespace App\Repository;

use App\Entity\Lot;
use App\Infra\EntityManagerCreator;
use Doctrine\ORM\EntityManagerInterface;

class LotRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct()
    {
        $this->entityManager = (new EntityManagerCreator())->getEntityManager();
    }

    public function getLotById(string $lotId)
    {
        return $this->entityManager->find(Lot::class, $lotId);
    }
}