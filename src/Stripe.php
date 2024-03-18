<?php

declare(strict_types=1);

namespace Verdient\Stripe;

use Verdient\HttpAPI\AbstractClient;

/**
 * Stripe
 * @author Verdient。
 */
class Stripe extends AbstractClient
{
    /**
     * @var string 客户端编号
     * @author Verdient。
     */
    public $clientId = null;

    /**
     * @var string 客户端秘钥
     * @author Verdient。
     */
    public $clientSecret = null;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public $protocol = 'https';

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public $host = 'api.stripe.com';

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public $routePrefix = 'v1';

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public $request = Request::class;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function request($path): Request
    {
        $request = parent::request($path);
        $request->addHeader('Authorization', 'Bearer ' . $this->clientSecret);
        return $request;
    }
}
