<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])) {

    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, $_POST['password']);

    showAlertDialogMethod("log in clicked biatch");

}
//action="register.php"method="post" enctype="multipart/form-data"
?>

<form action="#" method="post"  enctype="multipart/form-data" class="navbar-form navbar-right nav-bar-form">
    <div class="form-group">
        <input type="text" placeholder="Username" name="username" id="username" class="form-control">
    </div>
    <div class="form-group">
        <input type="password" placeholder="Password" name="password" id="password" class="form-control">
    </div>
    <button type="submit" name="login" id="login" class="btn btn-success">Sign in</button>

    <a class="btn btn-primary" href="register.php">Register</a>
</form>