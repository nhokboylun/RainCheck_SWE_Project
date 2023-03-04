<?php
require_once 'vendor/autoload.php';
require_once 'class-db.php';
  
define('GOOGLE_CLIENT_ID', '533455041939-vaql3n86sv5fc58p2mqq4nlbs2jqppc6.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
  
$config = [
    'callback' => 'https://melvin-projects.com/RainCheck_SWE_Project/MailSender/callback.php',
    'keys'     => [
                    'id' => GOOGLE_CLIENT_ID,
                    'secret' => GOOGLE_CLIENT_SECRET
                ],
    'scope'    => 'https://mail.google.com',
    'authorize_url_parameters' => [
            'approval_prompt' => 'force', // to pass only when you need to acquire a new refresh token.
            'access_type' => 'offline'
    ]
];
  
$adapter = new Hybridauth\Provider\Google( $config );