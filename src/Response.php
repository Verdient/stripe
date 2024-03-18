<?php

declare(strict_types=1);

namespace Verdient\Stripe;

use Verdient\http\Response as HttpResponse;
use Verdient\HttpAPI\AbstractResponse;
use Verdient\HttpAPI\Result;

/**
 * 响应
 * @author Verdient。
 */
class Response extends AbstractResponse
{
    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function normailze(HttpResponse $response): Result
    {
        $result = new Result();
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();
        $result->data = $body;
        if ($statusCode >= 200 && 300 > $statusCode) {
            $result->isOK = true;
        } else {
            $result->errorCode = $statusCode;
            if (isset($body['error']) && isset($body['error']['message'])) {
                $result->errorMessage = $body['error']['message'];
            } else {
                $result->errorMessage = $response->getStatusMessage();
            }
        }
        return $result;
    }
}
