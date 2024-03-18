<?php

namespace Verdient\Stripe;

/**
 * Webhook 签名
 * @author Verdient。
 */
class WebhookSignature
{
    const EXPECTED_SCHEME = 'v1';

    /**
     * 验证签名
     * @param string $payload 载荷原文
     * @param string $signature 签名
     * @param string $secret 秘钥
     * @param int $tolerance 公差
     * @author Verdient。
     */
    public static function verify($payload, $signature, $secret, $tolerance = 300)
    {
        $timestamp = self::getTimestamp($signature);
        $signatures = self::getSignatures($signature, self::EXPECTED_SCHEME);
        if (-1 === $timestamp) {
            return false;
        }
        if (empty($signatures)) {
            return false;
        }
        $signedPayload = "{$timestamp}.{$payload}";
        $expectedSignature = hash_hmac('sha256', $signedPayload, $secret);
        $signatureFound = false;
        foreach ($signatures as $signature) {
            if (hash_equals($expectedSignature, $signature)) {
                $signatureFound = true;
                break;
            }
        }
        if (!$signatureFound) {
            return false;
        }
        if (($tolerance > 0) && (abs(time() - $timestamp) > $tolerance)) {
            return false;
        }
        return true;
    }

    /**
     * 获取时间戳
     * @param string $signature 签名
     * @return int
     * @author Verdient。
     */
    protected static function getTimestamp($signature)
    {
        $items = explode(',', $signature);
        foreach ($items as $item) {
            $itemParts = explode('=', $item, 2);
            if ('t' === $itemParts[0]) {
                if (!is_numeric($itemParts[1])) {
                    return -1;
                }
                return (int) ($itemParts[1]);
            }
        }
        return -1;
    }

    /**
     * 获取签名
     * @param string $signature 签名
     * @param string $scheme 体系
     * @return array
     * @author Verdient。
     */
    protected static function getSignatures($signature, $scheme)
    {
        $signatures = [];
        $items = explode(',', $signature);
        foreach ($items as $item) {
            $itemParts = explode('=', $item, 2);
            if (trim($itemParts[0]) === $scheme) {
                $signatures[] = $itemParts[1];
            }
        }
        return $signatures;
    }
}
