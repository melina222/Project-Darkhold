<?php
function showAlertDialogMethod($warningText)
{
    print '<script type="text/javascript">';
    print 'alert("' . $warningText . '")';
    print '</script>';
}

function redirect($url)
{
    if (headers_sent()) {
        die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
    } else {
        header('Location: ' . $url);
        die();
    }
}
/*student,teacher*/
function get_role_string($role_int){
    if($role_int == 0){
        return "teacher";
    }else{
        return "student";
    }
}

function get_user_by_username($link, $username)
{
    include("user.php");
    $sql = "SELECT * "
        . "FROM user WHERE username='$username' ";
    $user = null;
    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        $row = mysqli_fetch_assoc($result);
        $user = new User($row['fname'], $row['username'], $row['lname'], $row['email'], $row['role'], $row['password']);
    }
    return $user;
}

function add_user($link, $fname, $lname, $email, $username, $password, $role)
{
    mysqli_autocommit($link, false);

    $hashedPassword = md5($password);

    $query = "insert into user 
                            (
                                fname,
                                lname,
								email,
                                username,
                                password,
                                role
                            ) 
                            Values
                            (
                                '$fname',
                                '$lname',
								'$email',
                                '$username',
                                '$hashedPassword',
                                 $role
                            )";
    $result = mysqli_query($link, $query);

    if ($result) {
        mysqli_commit($link);
        showAlertDialogMethod("Επιτυχής εγγραφή");
        return true;
    } else {
        mysqli_rollback($link);
        showAlertDialogMethod("Αδυναμία εισαγωγής νεου χρήστη");
        return false;
    }
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateRandomNumber($length = 3)
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return intval($randomString);
}

function createRandomMathFormula()
{

    $numA = generateRandomNumber(1);
    $numB = generateRandomNumber(1);
    //showAlertDialogMethod(intval($numA) + intval($numB) . " >" . $numA . " >" . $numB);
    $_SESSION['math_eval'] = intval($numA) + intval($numB);
    return $numA . " + " . $numB . " = ;";


}

function sendEmail($email, $code)
{
    require_once 'email_related/class.phpmailer.php';
    ini_set('display_errors', 1);
    $mail = new PHPMailer();
    $mail->charSet = 'utf-8';
    $mail->IsSMTP();
    $mail->Host = "smtp.aegean.gr";
    $mail->SMTPAuth = true;
    $mail->Port = 587;
    $mail->AuthType = "LOGIN";
    $mail->SMTPSecure = "tls";
    $mail->Username = "icsd12013";
    $mail->Password = "maragk123!";
    $mail->SMTPDebug = true;
    $mail->Debugoutput = "error_log";
    $mail->SetFrom("icsd12013@icsd.aegean.gr", "");
    $mail->AddReplyTo("icsd12013@icsd.aegean.gr", "");
    $mail->AddAddress($email, "");
    $mail->Subject = "V-Strom Greek Riders";
    $msg = "Μάστορα έχουμε εκδρομή, θα έρθεις;";
    $msg = $msg . " Code: " . $code;
    $mail->IsHTML(true);
    $mail->MsgHTML($msg);
    $mail->Send();
}

?>