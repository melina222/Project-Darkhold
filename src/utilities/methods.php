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

function get_user_by_id($link, $user_id)
{
    include("user.php");
    $sql = "SELECT * "
        . "FROM user WHERE id='$user_id' ";
    $user = null;
    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        $row = mysqli_fetch_assoc($result);
        $user = new User($row['fname'], $row['username'], $row['lname'], $row['email'], $row['role'], $row['password'], $row['id']);
    }
    return $user;
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

/*function update_thesis_state($link,$state,$thesis_id,$student_id){

    $sql="UPDATE the SET katastash=$anazhthsh WHERE id_diplwmatikhs=$title " ;
}*/


function update_thesis_application_state($link, $state, $thesis_id, $student_id)
{
    mysqli_autocommit($link, false);
    $sql = "UPDATE thesis_application
            SET state='$state'
            WHERE thesis_application.thesis_id = '$thesis_id' AND thesis_application.user_id='$student_id'";

    $result = mysqli_query($link, $sql);
    if ($result) {
        mysqli_commit($link);
        showAlertDialogMethod("OK");
        return true;
    } else {
        mysqli_rollback($link);
        showAlertDialogMethod("NOT OK");
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

function insert_thesis_apply_for_student($link, $thesis_id, $user_id)
{
    mysqli_autocommit($link, false);


    $query = "insert into thesis_appication 
                            (
                                thesis_id,
                                user_id
                            ) 
                            Values
                            (
                                '$thesis_id',
                                '$user_id'
                            )";

    $result = mysqli_query($link, $query);

    if ($result) {
        mysqli_commit($link);
        showAlertDialogMethod("Επιτυχής υποβολή αίτησης");
        return true;
    } else {
        mysqli_rollback($link);
        showAlertDialogMethod("Αδυναμία υποβολής αίτησης");
        return false;
    }
}

function get_state_string_by_id($id)
{
    if ($id == 1) {
        return 'Δεν έχει ανατεθεί';
    } else if ($id == 2) {
        return 'Υπο έγκριση';
    } else if ($id == 3) {
        return 'Έχει ανατεθεί σε φοιτητή/φοιτητές';
    } else if ($id == 4) {
        return 'Έτοιμη για παρουσίαση';
    } else if ($id == 5) {
        return 'Έχει ολοκληρωθεί';
    } else {
        return 'yolo';
    }
}


function change_thesis_state($link, $thesis_id, $new_state)
{
    mysqli_autocommit($link, false);
    $sql = "UPDATE thesis
            SET state='$new_state'
            WHERE thesis.id = '$thesis_id'";

    $result = mysqli_query($link, $sql);
    if ($result) {
        mysqli_commit($link);
        //showAlertDialogMethod("OK");
        return true;
    } else {
        mysqli_rollback($link);
        //showAlertDialogMethod("NOT OK");
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

function get_thesis_by_state($link, $state)
{
    $sql = "SELECT * FROM thesis WHERE state='$state'";
    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
    $count = mysqli_num_rows($result);
    if ($count >= 1) {
        return $result;
    }
    return null;
}

function get_thesis_for_teacher_that_students_applied_for($link, $teacher_id)
{
    showAlertDialogMethod($teacher_id);
    $sql = "SELECT thesis.*,thesis_appication.user_id FROM thesis,thesis_appication,user WHERE user.id = thesis.teacher_id AND user.id = '$teacher_id' AND thesis_appication.thesis_id = thesis.id";
    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
    $count = mysqli_num_rows($result);
    if ($count >= 1) {
        return $result;
    }
    return null;
}

function get_thesis_by_id($link, $thesis_id)
{
    $sql = "SELECT * FROM thesis WHERE id='$thesis_id'";
    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        return $result;
    }
    return null;
}


function get_thesis_student_applied_for($link, $student_id)
{

    $sql = "SELECT DISTINCT thesis.* FROM thesis,thesis_appication WHERE thesis.id = thesis_appication.thesis_id AND thesis_appication.user_id = $student_id";
    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
    $count = mysqli_num_rows($result);
    if ($count >= 1) {
        return $result;
    }
    return null;
}

function get_thesis_with_keywords($link, $keyword_phrase)
{

    $final_keywords = array();
    // showAlertDialogMethod($keyword_phrase . "<");

    $keywords = explode(" ", $keyword_phrase);

    foreach ($keywords as $keyword) {

        // showAlertDialogMethod(">" . $keyword);
        if (empty($keyword)) {
            showAlertDialogMethod("KEEP");
            continue;
        }


        /*$final_keywords[] = $keyword;*/
        array_push($final_keywords, $keyword);
    }


    if (empty($final_keywords)) {
        // showAlertDialogMethod("NULL");
        return null;
    }

    $sql = "SELECT DISTINCT thesis.* FROM thesis,user WHERE user.id = thesis.teacher_id AND thesis.state = 1 AND ";

    $counter = 0;

    foreach ($final_keywords as $final_keyword) {
        $sql = $sql . "thesis.title LIKE '%$final_keyword%' OR thesis.description LIKE '%$final_keyword%' OR user.fname LIKE '%$final_keyword%' OR user.lname LIKE '%$final_keyword%'";
        if ($counter < count($final_keywords) - 1) {
            $sql = $sql . " OR ";
        }
        $counter++;
    }

    // showAlertDialogMethod($sql);

    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
    $count = mysqli_num_rows($result);
    if ($count >= 1) {
        return $result;
    }
    return null;


}

function get_full_teacher_name_for_thesis($link, $thesis_id)
{
    $sql = "SELECT user.fname,user.lname FROM user,thesis WHERE thesis.teacher_id = user.id AND thesis.id = '$thesis_id'";
    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        while ($row = $result->fetch_assoc()) {
            return $row['fname'] . " " . $row['lname'];
        }
    }
    return null;
}

function get_full_student_name_for_thesis($link, $user_id)
{
    $sql = "SELECT user.fname,user.lname FROM user WHERE user.id= '$user_id'";
    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        while ($row = $result->fetch_assoc()) {
            return $row['fname'] . " " . $row['lname'];
        }
    }
    return null;
}


function get_lesson_names_as_string_for_thesis($link, $thesis_id)
{
    $lessons = get_lessons_for_thesis($link, $thesis_id);
    $name = "";
    if ($lessons != null) {
        while ($row = $lessons->fetch_assoc()) {
            $name = $name . $row['name'] . ', ';
        }
        return $name;
    } else {
        return "Κανένα";
    }
}

function get_lessons_for_thesis($link, $thesis_id)
{
    $sql = "SELECT lesson.name, lesson.semester FROM thesis_lesson_correlation,lesson WHERE thesis_lesson_correlation.thesis_id='$thesis_id' AND thesis_lesson_correlation.lesson_id = lesson.id";
    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
    $count = mysqli_num_rows($result);
    if ($count >= 1) {
        return $result;
    }
    return null;
}

function add_thesis_lessons($link, $thesis_id, $lesson_field)
{
    $success = true;
    //showAlertDialogMethod(" > " . (string)$lesson_field . "<");
    mysqli_autocommit($link, false);


    $lesson_ids = explode(" ", (string)$lesson_field);
    foreach ($lesson_ids as $lesson_id) {
        //showAlertDialogMethod(" >>>" . $lesson_id);

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
            /*showAlertDialogMethod($lesson_id . " <> " . $thesis_id);
            showAlertDialogMethod($query);*/
            $success = false;
        }
    }
    if ($success) {
        mysqli_commit($link);
        return true;
    } else {
        // showAlertDialogMethod("FAIL");
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
    //showAlertDialogMethod(intval($numA) + intval($numB) . " > " . $numA . " >" . $numB);
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

function get_approved_users_for_thesis($link, $thesis_id)
{
    $sql = "SELECT student_number FROM thesis WHERE id='$thesis_id'";
    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        while ($row = $result->fetch_assoc()) {
            return $row['student_number'];
        }
    }
    return null;
}

function get_thesis_applicants($link, $thesis_id)
{
    $sql = "SELECT COUNT(id) as num FROM thesis_application WHERE 	thesis_id='$thesis_id' AND state=1";
    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        while ($row = $result->fetch_assoc()) {
            return $row['num'];
        }
    }
    return null;
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
    $mail->Subject = "V - Strom Greek Riders";
    $msg = "Μάστορα έχουμε εκδρομή, θα έρθεις;";
    $msg = $msg . " Code: " . $code;
    $mail->IsHTML(true);
    $mail->MsgHTML($msg);
    $mail->Send();
}

function send_mail_to_user($email, $message, $path = "path")
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
    $mail->Subject = "Σύστημα διπλωματικών Πανεπιστήμιο Αιγαίου";
    /* $msg = "Μάστορα έχουμε εκδρομή, θα έρθεις;";*/
    if ($path != "path") {
        $mail->AddAttachment($path, $message, $encoding = 'base64', $type = 'application/pdf');      // attachment
    }
    $msg = $message;
    $mail->IsHTML(true);
    $mail->MsgHTML($msg);
    $mail->Send();
}

?>