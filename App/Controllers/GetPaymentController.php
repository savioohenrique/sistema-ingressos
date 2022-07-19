<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\PaymentService;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetPaymentController implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (!array_key_exists('id', $request->getQueryParams())) {
            return new Response(422, [], json_encode(['error' => 'The id must pe provided']));
        }

        ['id' => $paymentId] = $request->getQueryParams();
        try {
            $response = (new PaymentService())->getPayment($paymentId);
        } catch (\Exception $e) {
            $message = "Error: {$e->getMessage()}";
            return new Response(400, [], $message);
        }

        return new Response(200, [], $response);
    }
}
