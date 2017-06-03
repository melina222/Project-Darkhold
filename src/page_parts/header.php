<?php
session_start();
include_once "utilities/connectWithDB.php";
include_once "utilities/methods.php";
$_SESSION['user_role'] = 'teacher';
$_SESSION['login_state'] = false;
?>
<nav class="navbar navbar-default nav-bar-height navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand nav-bar-logo-position" href="#">
                <img height="60" width="60" alt="Brand" src="assets/logo.png">
                <?php
                if ($_SESSION['login_state'] == true) {
                    if (isset($_SESSION['user_role']) && !empty($_SESSION['user_role'])) {
                        if ($_SESSION['user_role'] == 'teacher') {
                            echo '<a class="navbar-brand nav-bar-brand" href="#">Πλατφόρμα Καθηγητή</a>';
                        } else if ($_SESSION['user_role'] == 'student') {
                            echo '<a class="navbar-brand nav-bar-brand" href="#">Πλατφόρμα Μαθητή</a>';
                        }
                    } else {
                        echo '<a class="navbar-brand nav-bar-brand"  href="#">Πλατφόρμα Διπλωματικών</a>';
                    }
                } else {
                    echo '<a class="navbar-brand nav-bar-brand" href="#">Πανεπιστήμιο Αιγαίου Τμήμα Μηχανικών Πληροφοριακών & Επικοινωνιακών Συστημάτων</a>';
                }

                if (isset($_SESSION['login_state']) && !empty($_SESSION['login_state'])) {
                    if ($_SESSION['login_state'] == true) {
                        include_once "header_logged_in_user.php";
                    } else {
                        include_once "header_login_form.php";
                    }
                } else {
                    include_once "header_login_form.php";
                }
                ?>
        </div>
        <?php
        if (isset($_SESSION['login_state']) && !empty($_SESSION['login_state'])) {
            if ($_SESSION['login_state'] == true) {
                if (isset($_SESSION['user_role']) && !empty($_SESSION['user_role'])) {
                    if ($_SESSION['user_role'] == 'teacher') {
                        include_once "header_options_teacher.php";
                    } else if ($_SESSION['user_role'] == 'student') {
                        include_once "header_options_student.php";
                    }
                }
            }
        }
        ?>
    </div>
</nav>