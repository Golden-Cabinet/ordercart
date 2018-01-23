<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/************************************************************

  This class is basically a PHPMailer wrapper so we can
  include and reference PHPMailer like a CI library

************************************************************/

class GCEmail {
  
  private $PHPMailer;
  private $config;
  
  function __construct($config = false) {
      require_once 'phpmailer/PHPMailerAutoload.php';
      $this->config = $config;
      return $this->PHPMailer;      
  }
  
  public function send($to_address, $subject, $message) {
    $mail = new PHPMailer;

    //Tell PHPMailer to use SMTP
    $mail->isSMTP();


    //Create a new PHPMailer instance
    $mail = new PHPMailer;

    //Tell PHPMailer to use SMTP
    $mail->isSMTP();

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 2;

    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'error_log';

    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
    // use
    // $mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6

    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;
    
    // Set the character encoding
    $mail->CharSet = "UTF-8";

    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls';

    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = $this->config['smtp_user'];

    //Password to use for SMTP authentication
    $mail->Password = $this->config['smtp_pass'];

    //Set who the message is to be sent from
    $mail->setFrom($this->config['store_email'], $this->config['store_email_name']);
    // $mail->setFrom("accounts@goldencabinetherbs.com", "Golden Cabinet Herbs");
    //Set an alternative reply-to address
    // $mail->addReplyTo('replyto@example.com', 'First Last');

    //Set who the message is to be sent to
    $mail->addAddress($to_address);

    //Set the subject line
    $mail->Subject = $subject;

    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $mail->msgHTML($message . '<div style="text-align:center;"><br><img src="https://staging.goldencabinetherbs.com/assets/images/golden-cabinet-logo.png" alt="" width=180/></div>');

    //Replace the plain text body with one created manually
    // $mail->AltBody = 'This is a plain-text message body';

    //Attach an image file
    // $mail->addAttachment('images/phpmailer_mini.png');
    try {
      if ( $mail->send() ) {
        return true;
      }else{
        return false;
      }
    }catch(Exception $e) {
      print_r($e);
    }
  }
}


