<?php
require_once 'email_related/class.phpmailer.php';
ini_set('display_errors', 1);
$mail             = new PHPMailer();
$mail->charSet = 'utf-8';
$mail->IsSMTP();
$mail->Host       = "smtp.aegean.gr";
$mail->SMTPAuth   = true;
$mail->Port   = 587;
$mail->AuthType = "LOGIN";
$mail->SMTPSecure = "tls";
$mail->Username="icsd12013";
$mail->Password="maragk123!";
$mail->SMTPDebug=true;
$mail->Debugoutput="echo";
$mail->SetFrom("icsd12013@icsd.aegean.gr", "");
$mail->AddReplyTo("icsd12013@icsd.aegean.gr", "");
$mail->AddAddress("NA PAREI EMAIL APO XRISTI", "");
$mail->Subject = "Εγγραφή νέου χρήστη";
$msg = "Κάνε κλικ στο σύνδεσμο για να επιλέξεις ρόλο χρήστη, βάζοντας τον κωδικό.";
$msg = "LINK";
$mail->IsHTML(true);
$mail->MsgHTML($msg);
$mail->Send();
?>