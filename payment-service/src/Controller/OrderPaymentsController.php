<?php

namespace App\Controller;


use App\Entity\Payment;
use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderPaymentsController extends AbstractController
{
    /**
     * @Route("/api/v1/orders/{orderId}/payments", name="order_payments")
     */
    public function payments(string $orderId, PaymentRepository $paymentRepository): Response
    {
        $payments = $paymentRepository->findByOrderIdField($orderId);

        return new JsonResponse(
            array_map(
                fn (Payment $payment) => $payment->toArray(),
                $payments
            )
        );
    }
}