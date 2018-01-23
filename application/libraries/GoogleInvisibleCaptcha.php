<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/************************************************************

  This class is basically a PHPMailer wrapper so we can
  include and reference PHPMailer like a CI library

************************************************************/

class GoogleInvisibleCaptcha {
  
  private $secret = "6Lfr8BMUAAAAANERLFIjMLK_xmZAX_dnC0rUQef8";
  private $remote_url = "https://www.google.com/recaptcha/api/siteverify";
  
  function __construct() {
  }
  
  public function verify() {
    $defaults = array(
    CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_POSTFIELDS => [
          'secret' => "6Lfr8BMUAAAAANERLFIjMLK_xmZAX_dnC0rUQef8",
          'response'  => $_POST['g-recaptcha-response'],
          'remoteip' => $_SERVER['REMOTE_ADDR']
        ],
    );
    
    $ch = curl_init();
    curl_setopt_array($ch, $defaults);
    $response = json_decode(curl_exec($ch));
    curl_close($ch);
    
    if ($response->success) {
      return true;
    }else{
      return false;
    }    
    
  }
}


