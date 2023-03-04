<?php
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
 
send_email_to_user('nhoklunboy1@gmail.com');
 
function send_email_to_user($email) {
    require_once 'config.php';
 
    $db = new DB();
    $arr_token = (array) $db->get_access_token();
 
    try {
        $transport = Transport::fromDsn('gmail+smtp://'.urlencode('raincheckswe@gmail.com').':'.urlencode($arr_token['access_token']).'@default');
 
        $mailer = new Mailer($transport);
 
        $message = (new Email())
            ->from('Rain Check <raincheckswe@gmail.com>')
            ->to($email)
            ->subject('Email through Gmail API')
            ->html('<h2>Email sent through Gmail API</h2>');
 
        // Send the message
        $mailer->send($message);
 
        echo 'Email sent successfully.';
    } catch (Exception $e) {
        if( !$e->getCode() ) {
            $refresh_token = $db->get_refersh_token();
 
            $response = $adapter->refreshAccessToken([
                "grant_type" => "refresh_token",
                "refresh_token" => $refresh_token,
                "client_id" => GOOGLE_CLIENT_ID,
                "client_secret" => GOOGLE_CLIENT_SECRET,
            ]);
             
            $data = (array) json_decode($response);
            $data['refresh_token'] = $refresh_token;
 
            $db->update_access_token(json_encode($data));
 
            send_email_to_user($email);
        } else {
            echo $e->getMessage(); //print the error
        }
    }
}