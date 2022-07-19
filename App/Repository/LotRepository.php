<?php

namespace App\Repository;

use App\Entity\Lot;
use App\Infra\EntityManagerCreator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class LotRepository
{
    private EntityManagerInterface $entityManager;
    private EntityRepository $entityRepository;

    public function __construct()
    {
        $entityManager = EntityManagerCreator::getEntityManager();
        $this->entityManager = $entityManager;
        $this->entityRepository = $entityManager->getRepository(Lot::class);
    }

    public function getLotById(string $lotId)
    {
        return $this->entityRepository->find($lotId);
    }

    public function reserveTickets(Lot $lot, int $ticketQuantity)
    {
        $lot->reserveTickets($ticketQuantity);
        $this->entityManager->flush();
    }
}