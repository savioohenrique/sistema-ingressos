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

        $response = PaymentService::createPayment($paymentData);
        echo "<pre>";
        var_dump($response);

        return new Response(200, [], 'Message received');
    }
}
