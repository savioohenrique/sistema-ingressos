<?php

declare(strict_types=1);

namespace App\Controllers;

use App\DTO\PaymentData;
use App\Services\PaymentService;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CreatePaymentController implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $paymentData = PaymentData::fromHttpRequest($request);
        } catch (\Exception $e) {
            return new Response(422, [], $e->getMessage());
        }

        try {
            $response = (new PaymentService())->createPayment($paymentData);
        } catch (\Exception $e) {
            $message = "Error: {$e->getMessage()}";
            return new Response(400, [], $message);
        }

        return new Response(201, [], $response);
    }
}
