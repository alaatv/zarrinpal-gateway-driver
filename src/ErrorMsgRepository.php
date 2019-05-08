<?php

namespace AlaaTV\ZarinpalGatewayDriver;

class ErrorMsgRepository
{
    protected static $errors = [
        -1  => 'اطلاعات ارسال شده ناقص است.',
        -2  => 'IP و یا مرچنت کد پذیرنده صحیح نیست',
        -3  => 'رقم باید بالای 100 تومان باشد',
        -4  => 'سطح پذیرنده پایین تر از سطح نقره ای است',
        -11 => 'درخواست مورد نظر یافت نشد',
        -21 => 'کاربر قبل از ورود به درگاه بانک در همان صفحه زرین پال منصرف شده است.',
        -22 => 'تراکنش ناموفق می باشد. کاربر بعد از ورود به درگاه بانک منصرف شده است.',
        -33 => 'رقم تراکنش با رقم پرداخت شده مطابقت ندارد',
        -54 => 'درخواست مورد نظر آرشیو شده',
        100 => 'عملیات با موفقیت انجام شد',
        101 => 'عملیات پرداخت با موفقیت انجام شده ولی قبلا عملیات PaymentVertification بر روی این تراکنش انجام شده است',
    ];

    public static function getMsg($code)
    {
        return self::$errors[$code] ?? 'خطای نامعلوم';
    }
}