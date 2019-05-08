<?php

return [

    'merchantID' => env('ZARINPAL_MERCHANT_ID'),

    'driver' => env('ZARINPAL_DRIVER', 'Rest'),

    'Sandbox' => env('ZARINPAL_SANDBOX', true),

    'ZarinGate' => env('ZARINPAL_GATE', true),
];
