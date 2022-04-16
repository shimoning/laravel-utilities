<?php

return [
    // for Database logger
    'db_logging' => env('DB_LOGGING', false),
    'db_logging_channel' => env('DB_LOGGING_CHANNEL', false),

    // for Mail logger
    'mail_logging' => env('MAIL_LOGGING', false),
    'mail_logging_channel' => env('MAIL_LOGGING_CHANNEL', false),
];
