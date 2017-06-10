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
function get_role_string($role_int)
{
    if ($role_int == 0) {
        return "teacher";
    } else {
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
        $user = new User($row['fname'], $row['username'], $row['lname'], $row['email'], $row['role'], $row['password'], $row['id']);
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

function add_thesis($link, $title, $user_id, $student_number, $target, $description, $knowledge, $lesson_field)
{
    mysqli_autocommit($link, false);


    $query = "insert into thesis 
                            (
                                title,
                                teacher_id,
								student_number,
                                student_knowledge,
                                state,
                                description,
                                target
                            ) 
                            Values
                            (
                                '$title',
                                '$user_id',
								$student_number,
                                '$knowledge',
                                1,
                                '$description',
                                '$target'
                            )";

    $result = mysqli_query($link, $query);

    if ($result) {
        mysqli_commit($link);
        $inserted_thesis_id = get_thesis($link, $title, $user_id, $student_number, $target, $description, $knowledge);

        if (intval($inserted_thesis_id) > 0) {
            $success = add_thesis_lessons($link, $inserted_thesis_id, $lesson_field);
            if ($success) {
                showAlertDialogMethod("Επιτυχής εισαγωγή");
                return true;
            } else {
                showAlertDialogMethod("Αδυναμία εισαγωγής νέας δηπλωματικής");
                return false;
            }

        } else {
            mysqli_rollback($link);
            showAlertDialogMethod("Αδυναμία εισαγωγής νέας δηπλωματικής");
            return false;
        }

    } else {
        mysqli_rollback($link);
        showAlertDialogMethod("Αδυναμία εισαγωγής νέας δηπλωματικής");
        return false;
    }
}

function get_thesis($link, $title, $user_id, $student_number, $target, $description, $knowledge)
{
    $sql = "SELECT id FROM thesis WHERE title='$title' AND teacher_id='$user_id' AND student_number=$student_number AND student_knowledge='$knowledge' AND state=1 AND description='$description' AND target='$target'";
    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        while ($row = $result->fetch_assoc()) {
            return $row['id'];
        }
    }
    return null;
}

function add_thesis_lessons($link, $thesis_id, $lesson_field)
{
    $success = true;
    showAlertDialogMethod(">" . (string)$lesson_field . "<");
    mysqli_autocommit($link, false);


    $lesson_ids = explode(" ", (string)$lesson_field);
    foreach ($lesson_ids as $lesson_id) {
        showAlertDialogMethod(">>>" . $lesson_id);

        if (empty($lesson_id)) {
            continue;
        }


        $query = "insert into thesis_lesson_correlation
                            (
                               thesis_id,
                               lesson_id
                            ) 
                            Values
                            (
                                '$thesis_id',
                                '$lesson_id'
                                                            )";

        $result = mysqli_query($link, $query);

        if (!$result) {
            showAlertDialogMethod($lesson_id . "<>" . $thesis_id);
            showAlertDialogMethod($query);
            $success = false;
        }
    }
    if ($success) {
        mysqli_commit($link);
        return true;
    } else {
        showAlertDialogMethod("FAIL");
        mysqli_rollback($link);
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

function getLessonsFromDatabase($link)
{
    $sql = "SELECT id, name FROM lesson";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        return ($result);
    } else {
        echo "0 results";
    }
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