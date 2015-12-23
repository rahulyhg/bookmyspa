<?php

App::import('Vendor', 'PHPMailer', array('file' => 'PHPMailer/class.phpmailer.php'));

class PHPMailerComponent extends Component {

    function sendmail($mailid, $fromEmail, $fromName, $subject, $message, $fileNameWithPath) {
        $mail = new PHPMailer();

        $body = $message;
        //$body             = preg_replace('/[\]/','',$body);

        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->Host = "smtp.gmail.com"; // SMTP server
        $mail->SMTPDebug = 2;                     // enables SMTP debug information (for testing)
        // 1 = errors and messages
        // 2 = messages only
        $mail->SMTPAuth = true;                  // enable SMTP authentication
        $mail->Host = "smtp.gmail.com"; // sets the SMTP server
        $mail->Port = 587;                    // set the SMTP port for the GMAIL server
        //$mail->Username   = "sdm.os46@gmail.com"; // SMTP account username
        $mail->Username = "join.vaibhav007@gmail.com"; // SMTP account username
        //$mail->Password   = "sdm#e2012";
        $mail->Password = "pramila007";
        $mail->SMTPSecure = 'tls';
        // SMTP account password

        $mail->SetFrom($fromEmail, $fromName);
        //$mail->AddReplyTo("sdm.os46@gmail.com","First Last");
        //$mail->SetFrom('join.vaibhav007@gmail.com', 'Vaibhav Jain');
        //$mail->AddReplyTo("join.vaibhav007@gmail.com","First Last");

        $mail->Subject = $subject;

        //$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

        $mail->MsgHTML($body);

        $address = $mailid;
        $mail->AddAddress($address, "");

        $mail->AddAttachment($fileNameWithPath);      // attachment
        //$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            return true;
        }
    }

}
