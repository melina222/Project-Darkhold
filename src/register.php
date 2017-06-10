<html>
<head>
    <?php
    include_once "page_parts/head.php";
    ?>
</head>
<body class="container">
<?php
include_once "page_parts/header.php";
?>
<div class="page_content">
    <form action="register.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="fname">Όνομα:</label>
            <input required="required" type="text" class="form-control" id="fname" name="fname"
                   placeholder="First name">
        </div>
        <div class="form-group">
            <label for="lname">Επίθετο:</label>
            <input required="required" type="text" class="form-control" id="lname" name="lname" placeholder="Last name">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input required="required" type="email" class="form-control" id="email" name="email" placeholder="Email">
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input required="required" type="text" class="form-control" id="username" name="username"
                   placeholder="Username">
        </div>
        <div class="form-group">
            <label for="password">Κωδικός</label>
            <input required="required" type="password" class="form-control" id="password" name="password"
                   placeholder="Password">
        </div>
        <div class="form-group">
            <label for="rpassword">Επανάληψη Κωδικού:</label>
            <input required="required" type="password" class="form-control" id="rpassword" name="rpassword"
                   placeholder="Re-enter Password">
        </div>
        <!-- <div class="form-group">
             <label for="id_role">Ρόλος:</label>
             <select type="text" id="role" name="role">
                 <option value="1">Καθηγητής</option>
                 <option value="2">Φοιτητής</option>
             </select>
         </div>-->
        <button type="submit" name="register" class="btn btn-primary">Εγγραφή</button>

    </form>
</div>

</body>
</html>
<?php

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['register'])) {

    $fname = mysqli_real_escape_string($link, $_POST['fname']);
    $lname = mysqli_real_escape_string($link, $_POST['lname']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $rpassword = mysqli_real_escape_string($link, $_POST['rpassword']);
    /*  $role = mysqli_real_escape_string($link, $_POST['role']);*/

    if (empty($fname) || empty($lname) || (empty($username)) || empty($password) || empty($rpassword)) {
        showAlertDialogMethod('Πρέπει να συμπληρώσετε όλα πεδία.', 'error');
        //header("Location: register.php");
        exit();
    }

    if ($password != $rpassword) {
        showAlertDialogMethod("Οι κωδικοί πρέπει να ταιριάζουν");
        //header("Location: register.php");
        exit();
    }

    // TODO Create random confirmation password
    $randomPassword = generateRandomString();
    //showAlertDialogMethod($randomPassword);
    // TODO Send email with verification code
    sendEmail($email, $randomPassword);
    // TODO Add to session
    $_SESSION['confirmation_code'] = $randomPassword;
    $_SESSION['fname'] = $fname;
    $_SESSION['lname'] = $lname;
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;

    // TODO Redirect to post register page
    redirect("post_register.php");
    exit();
}
?>