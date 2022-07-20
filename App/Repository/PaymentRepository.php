<?php

namespace App\Repository;

use App\Entity\Payment;
use App\Infra\EntityManagerCreator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class PaymentRepository
{
    private EntityManager $entityManager;
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

    public function getPaymentByStatus(string $status): ?array
    {
        return $this->entityRepository->findBy(['status' => $status]);
    }

    public function cancelPayment(string $paymentId): Payment
    {
        $payment = $this->entityManager->find(Payment::class, $paymentId);
        $payment->setStatus('canceled');
        $this->entityManager->flush();

        return $payment;
    }

    public function confirmPayment(string $paymentId): Payment
    {
        $payment = $this->entityManager->find(Payment::class, $paymentId);
        $payment->setStatus('confirmed');
        $this->entityManager->flush();

        return $payment;
    }
}
