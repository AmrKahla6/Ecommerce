<?php 
return [ 
    'client_id' => env('PAYPAL_CLIENT_ID','AawV0Zf5Wue-jLH43WD_AxqvS74CV3H8H4U67hZJx_3GTeqO8XrpTIELelO3y_hQ70aQGezvQZsd6tlp'),
    'secret' => env('PAYPAL_SECRET','EM1gHze4TmaL1O63OmEKt6XXUUmgdhSSBwyElVbwCDVK9I1c-b6ArJbhj1D7A3LT2h1Bt1o3Ck4JH6f5'),
    'settings' => array(
        'mode' => env('PAYPAL_MODE','sandbox'),
        'http.ConnectionTimeOut' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'ERROR'
    ),
];