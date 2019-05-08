<?php

namespace AlaaTV\ZarinpalGatewayDriver;

use AlaaTV\Gateways\Contracts\IranianCurrency;
use AlaaTV\Gateways\Contracts\OnlineGateway;
use AlaaTV\Gateways\Contracts\OnlinePaymentVerificationResponseInterface;
use AlaaTV\Gateways\RedirectData;

class ZarinpalGateWay implements OnlineGateway
{
    public function generateAuthorityCode(string $callbackUrl, IranianCurrency $cost, string $description, $orderId = null)
    {
        $zarinpalResponse = resolve('zarinpal.client')->request($callbackUrl, $cost->tomans(), $description);

        return nullable($zarinpalResponse['Authority'] ?? null);
    }
    
    public function getAuthorityValue(): string
    {
        return $request['Authority'] ?? '';
    }
    
    public function generatePaymentPageUriObject($refId): RedirectData
    {
        $url = app('zarinpal.client')->redirectUrl();

        return RedirectData::instance($url);
    }
    
    public function verifyPayment(IranianCurrency $amount, $authority): OnlinePaymentVerificationResponseInterface
    {
        $result = app('zarinpal.client')->verify($amount->tomans(), $authority);

        return VerificationResponse::instance($result);
    }
}