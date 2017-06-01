<html>
<head>
    ad>
    <?php
    include_once "page_parts/head.php";
    ?>
</head>
<body class="container">
<?php
include_once "page_parts/header.php";
?>
<div class="page_content">
    <form>

        <div class="form-group">
            <label for="emailPass">Κωδικος επιβεβαιωσης με email:</label>
            <input type="text" class="form-control" id="emailPass" name="emailPass" placeholder="Email password">
        </div>

        <div class="form-group">
            <label for="id_role">Ρόλος:</label>
            <select type="text" id="role" name="role">
                <option value="1">Καθηγητής</option>
                <option value="2">Φοιτητής</option>
            </select>
        </div>

        <button type="submit" name="register" class="btn btn-primary">Ολοκληρωση εγγραφης</button>
    </form>
</div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['register'])) {

    $emailPass = mysqli_real_escape_string($link, $_POST['emailPass']);
    $role = mysqli_real_escape_string($link, $_POST['role']);

    if (isset($_SESSION['confirmation_code']) && !empty($_SESSION['confirmation_code'])) {
        if ($emailPass == $_SESSION['confirmation_code']) {
            // TODO Update user role on database
            // $_SESSION['inserted_user_id']
            // $sql = "update user set role='$role' where user_id='$_SESSION['inserted_user_id']'";

            // TODO check if successful
            // If OK
            // Unset session
        }
    }

    showAlertDialogMethod($role);
}
?>