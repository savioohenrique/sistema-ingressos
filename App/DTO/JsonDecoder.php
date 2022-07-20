<?php

namespace App\DTO;

use App\Exceptions\JsonDecoderException;

class JsonDecoder
{
    private string $responseBody;

    public function __construct(string $responseBody)
    {
        $this->responseBody = $responseBody;
    }

    public function decodeJsonToArray(): array
    {
        $decodedResonseBody = json_decode($this->responseBody, true);
        $decodedError = json_last_error() !== JSON_ERROR_NONE;

        if ($decodedError) {
            throw new JsonDecoderException(json_last_error_msg());
        }

        if (!is_array($decodedResonseBody)) {
            throw new JsonDecoderException('Error to decode the payload data into an array');
        }

        return $decodedResonseBody;
    }
}
