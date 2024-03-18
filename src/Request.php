<?php

declare(strict_types=1);

namespace Verdient\Stripe;

use Verdient\http\Request as HttpRequest;
use Verdient\http\serializer\body\UrlencodedBodySerializer;

/**
 * 请求
 * @author Verdient。
 */
class Request extends HttpRequest
{
    /**
     * @inheritdoc
     * @author Verdient。
     */
    public $bodySerializer = UrlencodedBodySerializer::class;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function send(): Response
    {
        $response = new Response(parent::send());
        return $response;
    }
}
