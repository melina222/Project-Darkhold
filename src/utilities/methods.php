<?php
function showAlertDialogMethod($warningText)
{
    print '<script type="text/javascript">';
    print 'alert("' . $warningText . '")';
    print '</script>';
}

function add_user($link, $fname, $lname, $email, $username, $password)
{
    mysqli_autocommit($link, false);

    $query = "insert into user 
                            (
                                fname,
                                lname,
								email,
                                username,
                                password
                            ) 
                            Values
                            (
                                '$fname',
                                '$lname',
								'$email',
                                '$username',
                                '$password'
                            )";
    echo $query;
//die;
    $success = mysqli_query($link, $query);
    if($success){
        return mysql_insert_id();
    }
    return -1;
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function sendEmail($email,$code){
    require_once '../email_related/class.phpmailer.php';
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
    $mail->Password="HIDDEN";
    $mail->SMTPDebug=true;
    $mail->Debugoutput="echo";
    $mail->SetFrom("icsd12013@icsd.aegean.gr", "");
    $mail->AddReplyTo("icsd12013@icsd.aegean.gr", "");
    $mail->AddAddress($email, "");
    $mail->Subject = "V-Strom Greek Riders";
    $msg = "Μάστορα έχουμε εκδρομή, θα έρθεις;";
    $msg = "Code: "+$code;
    $msg = "LINK";
    $mail->IsHTML(true);
    $mail->MsgHTML($msg);
    $mail->Send();
}
?>