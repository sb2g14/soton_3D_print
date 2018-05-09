<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],
    
    /*
    | Custom SAML Parameters
    */
    
    'SAML' => [
        'username' => ['SERVER_PORT',
                        'MELLON_cn','MELLON_cn_0',
                        'MELLON_uid','MELLON_uid_0',
                        'MELLON_urn:oid:2.5.4.3','MELLON_urn:oid:2.5.4.3_0',
                        'MELLON_urn:oid:2_5_4_3','MELLON_urn:oid:2_5_4_3_0',
                        'MELLON_urn:oid:0.9.2342.19200300.100.1.1','MELLON_urn:oid:0.9.2342.19200300.100.1.1_0',
                        'MELLON_urn:oid:0_9_2342_19200300_100_1_1','MELLON_urn:oid:0_9_2342_19200300_100_1_1_0',
                        ], //_Server variable key to identify successfull login
        'email' => ['MELLON_MAIL','MELLON_MAIL_0',
                    'MELLON_eduPersonPrincipalName','MELLON_eduPersonPrincipalName_0',
                    'MELLON_urn:oid:0.9.2342.19200300.100.1.3','MELLON_urn:oid:0.9.2342.19200300.100.1.3_0',
                    'MELLON_urn:oid:1.3.6.1.4.1.5923.1.1.1.6','MELLON_urn:oid:1.3.6.1.4.1.5923.1.1.1.6_0',
                    'MELLON_urn:oid:0_9_2342_19200300_100_1_3','MELLON_urn:oid:0_9_2342_19200300_100_1_3_0',
                    'MELLON_urn:oid:1_3_6_1_4_1_5923_1_1_1_6','MELLON_urn:oid:1_3_6_1_4_1_5923_1_1_1_6_0'
                    ], //_Server variable key for UoS email
        'lastname' => ['MELLON_sn','MELLON_sn_0',
                       'MELLON_urn:oid:2.5.4.4','MELLON_urn:oid:2.5.4.4_0',
                       'MELLON_urn:oid:2_5_4_4','MELLON_urn:oid:2_5_4_4_0',
                    ], //_Server variable key for UoS surname
        'firstname' => ['MELLON_urn:oid:2_5_4_42','MELLON_urn:oid:2_5_4_42_0'],
        'customer' => [
            'id' => 100, //user id of customer account
        ],
    ],

];
