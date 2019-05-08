<?php

namespace AlaaTV\ZarinpalGatewayDriver;

use AlaaTV\Gateways\Contracts\OnlinePaymentVerificationResponseInterface;

class VerificationResponse implements OnlinePaymentVerificationResponseInterface
{
    private $response;
    
    /**
     * VerificationResponse constructor.
     *
     * @param $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }
    
    public static function instance($result) : OnlinePaymentVerificationResponseInterface
    {
        return new static($result);
    }
    
    public function isVerifiedBefore()
    {
        return $this->getStatus() === 'verified_before';
    }
    
    private function getStatus(): string
    {
        return $this->response['Status'] ?? '';
    }
    
    public function getCardPanMask()
    {
        return $this->response['ExtraDetail']['Transaction']['CardPanMask'] ?? '';
    }
    
    public function getCardHash()
    {
        return $this->response['ExtraDetail']['Transaction']['CardPanHash'] ?? '';
    }
    
    public function getMessages() : array
    {
        if ($this->isSuccessfulPayment()) {
            
            $message = ['پرداخت کاربر تایید شد.'];
            if ($this->hasBeenVerifiedBefore()) {
                $message[] = ErrorMsgRepository::getMsg(101);
            }
            
            return $message;
        }
        
        if ($this->isCanceled()) {
            return ['کاربر از پرداخت انصراف داده است.'];
        }
        
        $message = ['خطایی در پرداخت رخ داده است.'];
        
        if ($this->response['error']) {
            $message[] = ErrorMsgRepository::getMsg($this->response['error']);
        }

        return $message;
    }
    
    public function isSuccessfulPayment(): bool
    {
        return in_array($this->getStatus(), ['verified_before', 'success',]) && $this->getRefId();
    }
    
    public function getRefId()
    {
        if (app()['zarinpal.isSandBox']) {
            return 'sandbox'.time();
        }
        
        return $this->response['RefID'] ?? '';
    }
    
    public function hasBeenVerifiedBefore(): bool
    {
        return $this->getStatus() === 'verified_before';
    }
    
    public function isCanceled(): bool
    {
        return $this->getStatus() === 'error' and  $this->response['error'] = -21;
    }
}