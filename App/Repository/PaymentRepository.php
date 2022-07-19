<?php

namespace App\Repository;

use App\Entity\Payment;
use App\Infra\EntityManagerCreator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class PaymentRepository
{
    private EntityManagerInterface $entityManager;
    private EntityRepository $entityRepository;

    public function __construct()
    {
        $entityManager = EntityManagerCreator::getEntityManager();
        $this->entityManager = $entityManager;
        $this->entityRepository = $entityManager->getRepository(Payment::class);
    }

    public function savePayment(Payment $payment): void
    {
        $this->entityManager->persist($payment);
        $this->entityManager->flush();
    }

    public function findPaymentById(string $paymentId): ?Payment
    {
        return $this->entityRepository->find($paymentId);
    }
}