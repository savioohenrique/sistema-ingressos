<?php

namespace App\Repository;

use App\Entity\Payment;
use App\Infra\EntityManagerCreator;
use Doctrine\ORM\EntityManagerInterface;

class PaymentRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct()
    {
        $this->entityManager = (new EntityManagerCreator())->getEntityManager();
    }

    public function savePayment(Payment $payment)
    {
        $this->entityManager->persist($payment);
        $this->entityManager->flush();
    }
}