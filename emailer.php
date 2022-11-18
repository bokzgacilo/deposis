<?php
// require phpmailer
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// for phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendRegistrationEmail($receiver, $receiver_name){
    $subject = "Registered Successfully";
    $message = "
      Good Day STIer!<br><br>
      Thank you <strong>" . $receiver_name . "</strong> for registering on Deposis. You may now use Deposis and it's feature.<br><br>
      If you have a question or concern regarding with your account creation or related with deposis. You can contact us by replying to this message.<br><br>
      At your service, <br>
      Deposis Team <a href='server.deposis@gmail.com'></a>
    ";
    $mail = new PHPMailer(true);
    
    $mail -> isSMTP();
    $mail -> Host = "smtp.gmail.com";
    $mail -> SMTPAuth = true;
    $mail -> Username = 'server.deposis@gmail.com';
    $mail -> Password = 'kymmtxqyomjpkcru';
    $mail -> SMTPSecure = 'ssl';
    $mail -> Port = 465;
  
    $mail -> setFrom('server.deposis@gmail.com', 'Deposis');
  
    $mail -> addAddress($receiver);

    $mail -> isHTML(true);
    $mail -> Subject = $subject;
    $mail -> Body = $message;
  
    $mail -> send();
}

?>