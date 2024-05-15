<?php

return [
    /**
     * Default expiry interval for newly created tokens.
     */
    'expire_interval' => '1 day',

    /**
     * Instead of creating and storing duplicate tokens, the package extends the expiry date of existing tokens.
     */
    'extend_interval' => '30 minutes',

    /**
     * Default registered providers.
     */
    'providers' => [
        'firebase' => \Elnooronline\Notifications\Services\Providers\FirebaseProvider::class,
    ],

    /**
     * Default provider config.
     */
    'provider' => [
        'queue' => \Elnooronline\Notifications\Services\Enums\QueueEnum::DATABASE,
    ],
];
