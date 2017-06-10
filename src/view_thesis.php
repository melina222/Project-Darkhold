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

<?php
include_once "page_parts/login_checker.php";
?>

<div class="page_content">


    <?php

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['edit'])) {

        $selected_thesis = mysqli_real_escape_string($link, $_POST['selected-thesis']);
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['chat'])) {

        $selected_thesis = mysqli_real_escape_string($link, $_POST['selected-thesis']);
    }

    ?>

    <h3>Κατάσταση: Δεν έχουν ανατεθεί</h3>
    <br>
    <table class="table">
        <?php
        $all_thesis = get_thesis_by_state($link, 1);
        if ($all_thesis == null) {

            echo '<h5>Δεν βρέθηκαν αποτελέσματα</h5>';


        } else {
            echo ' <tr>';
            echo '<td><h4>Τίτλος</h4></td>';
            echo '<td><h4>Περιγραφή</h4></td>';
            echo '<td><h4>Στόχος</h4></td>';
            echo '<td><h4>Αριθμός μαθητών</h4></td>';
            echo '<td><h4>Προαπαιτούμενες γνώσεις</h4></td>';
            echo '<td><h4>Προαπαιτούμενες μαθήματα</h4></td>';
            echo '<td><h4>Ημερομηνία δημοσίευσης</h4></td>';
            echo '<td><h4>Επεξεργασία</h4></td>';
            echo '<td><h4>Chat</h4></td>';
            echo '</tr>';
            while ($row = $all_thesis->fetch_assoc()) {
                echo '<tr>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['title'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['description'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['target'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['student_number'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['student_knowledge'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . get_lesson_names_as_string_for_thesis($link, $row['id']) . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['publication_date'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<form action="view_thesis.php" method="post" enctype="multipart/form-data">';
                echo '<input type="hidden" id="selected-thesis" name="selected-thesis" value="' . $row['id'] . '">';
                echo '<button type="submit" name="edit" class="btn btn-warning">Επεξεργασία</button>';
                echo '</form>';
                echo '</td>';
                echo '<td>';
                echo '<form action="view_thesis.php" method="post" enctype="multipart/form-data">';
                echo '<input type="hidden" id="selected-thesis" name="selected-thesis" value="' . $row['id'] . '">';
                echo '<button type="submit" name="chat" class="btn btn-primary">Chat</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        }
        ?>
    </table>

    <br>
    <h3>Κατάσταση: Yπο έγκριση</h3>
    <br>
    <table class="table">
        <?php
        $all_thesis = get_thesis_by_state($link, 2);
        if ($all_thesis == null) {

            echo '<h5>Δεν βρέθηκαν αποτελέσματα</h5>';


        } else {
            echo ' <tr>';
            echo '<td><h4>Τίτλος</h4></td>';
            echo '<td><h4>Περιγραφή</h4></td>';
            echo '<td><h4>Στόχος</h4></td>';
            echo '<td><h4>Αριθμός μαθητών</h4></td>';
            echo '<td><h4>Ονόματα Φοιτητών</h4></td>';
            echo '<td><h4>Προαπαιτούμενες γνώσεις</h4></td>';
            echo '<td><h4>Προαπαιτούμενες μαθήματα</h4></td>';
            echo '<td><h4>Ημερομηνία δημοσίευσης</h4></td>';
            echo '</tr>';
            while ($row = $all_thesis->fetch_assoc()) {
                echo '<tr>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['title'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['description'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['target'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['student_number'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['student_number'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['student_knowledge'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . get_lesson_names_as_string_for_thesis($link, $row['id']) . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['publication_date'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<form action="view_thesis.php" method="post" enctype="multipart/form-data">';
                echo '<input type="hidden" id="selected-thesis" name="selected-thesis" value="' . $row['id'] . '">';
                echo '<button type="submit" name="edit" class="btn btn-warning">Επεξεργασία</button>';
                echo '</form>';
                echo '</td>';
                echo '<td>';
                echo '<form action="view_thesis.php" method="post" enctype="multipart/form-data">';
                echo '<input type="hidden" id="selected-thesis" name="selected-thesis" value="' . $row['id'] . '">';
                echo '<button type="submit" name="chat" class="btn btn-primary">Chat</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        }
        ?>
    </table>

    <br>
    <h3>Κατάσταση: Έχουν ανατεθεί </h3>
    <br>
    <table class="table">
        <?php
        $all_thesis = get_thesis_by_state($link, 3);
        if ($all_thesis == null) {

            echo '<h5>Δεν βρέθηκαν αποτελέσματα</h5>';


        } else {
            echo ' <tr>';
            echo '<td><h4>Τίτλος</h4></td>';
            echo '<td><h4>Περιγραφή</h4></td>';
            echo '<td><h4>Στόχος</h4></td>';
            echo '<td><h4>Αριθμός μαθητών</h4></td>';
            echo '<td><h4>Ονόματα Φοιτητών</h4></td>';
            echo '<td><h4>Προαπαιτούμενες γνώσεις</h4></td>';
            echo '<td><h4>Προαπαιτούμενες μαθήματα</h4></td>';
            echo '<td><h4>Ημερομηνία δημοσίευσης</h4></td>';
            echo '<td><h4>Ημερομηνία ανάληψης θέματος</h4></td>';
            echo '</tr>';
            while ($row = $all_thesis->fetch_assoc()) {
                echo '<tr>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['title'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['description'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['target'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['student_number'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['student_number'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['student_knowledge'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . get_lesson_names_as_string_for_thesis($link, $row['id']) . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['publication_date'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['assignment_date'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<form action="view_thesis.php" method="post" enctype="multipart/form-data">';
                echo '<input type="hidden" id="selected-thesis" name="selected-thesis" value="' . $row['id'] . '">';
                echo '<button type="submit" name="edit" class="btn btn-warning">Επεξεργασία</button>';
                echo '</form>';
                echo '</td>';
                echo '<td>';
                echo '<form action="view_thesis.php" method="post" enctype="multipart/form-data">';
                echo '<input type="hidden" id="selected-thesis" name="selected-thesis" value="' . $row['id'] . '">';
                echo '<button type="submit" name="chat" class="btn btn-primary">Chat</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        }
        ?>
    </table>

    <br>
    <h3>Κατάσταση: Έτοιμες για παρουσίαση </h3>
    <br>
    <table class="table">
        <?php
        $all_thesis = get_thesis_by_state($link, 4);
        if ($all_thesis == null) {

            echo '<h5>Δεν βρέθηκαν αποτελέσματα</h5>';


        } else {
            echo ' <tr>';
            echo '<td><h4>Τίτλος</h4></td>';
            echo '<td><h4>Περιγραφή</h4></td>';
            echo '<td><h4>Στόχος</h4></td>';
            echo '<td><h4>Αριθμός μαθητών</h4></td>';
            echo '<td><h4>Ονόματα Φοιτητών</h4></td>';
            echo '<td><h4>Προαπαιτούμενες γνώσεις</h4></td>';
            echo '<td><h4>Προαπαιτούμενες μαθήματα</h4></td>';
            echo '<td><h4>Ημερομηνία δημοσίευσης</h4></td>';
            echo '<td><h4>Ημερομηνία ανάληψης θέματος</h4></td>';
            echo '</tr>';

            while ($row = $all_thesis->fetch_assoc()) {
                echo '<tr>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['title'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['description'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['target'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['student_number'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['student_number'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['student_knowledge'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . get_lesson_names_as_string_for_thesis($link, $row['id']) . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['publication_date'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['assignment_date'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<form action="view_thesis.php" method="post" enctype="multipart/form-data">';
                echo '<input type="hidden" id="selected-thesis" name="selected-thesis" value="' . $row['id'] . '">';
                echo '<button type="submit" name="edit" class="btn btn-warning">Επεξεργασία</button>';
                echo '</form>';
                echo '</td>';
                echo '<td>';
                echo '<form action="view_thesis.php" method="post" enctype="multipart/form-data">';
                echo '<input type="hidden" id="selected-thesis" name="selected-thesis" value="' . $row['id'] . '">';
                echo '<button type="submit" name="chat" class="btn btn-primary">Chat</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        }
        ?>
    </table>

    <br>
    <h3>Κατάσταση: Έχουν ολοκληρωθεί </h3>
    <br>
    <table class="table">
        <?php
        $all_thesis = get_thesis_by_state($link, 5);

        if ($all_thesis == null) {

            echo '<h5>Δεν βρέθηκαν αποτελέσματα</h5>';

        } else {

            echo ' <tr>';
            echo '<td><h4>Τίτλος</h4></td>';
            echo '<td><h4>Περιγραφή</h4></td>';
            echo '<td><h4>Στόχος</h4></td>';
            echo '<td><h4>Αριθμός φοιτητών</h4></td>';
            echo '<td><h4>Ονόματα Φοιτητών</h4></td>';
            echo '<td><h4>Προαπαιτούμενες γνώσεις</h4></td>';
            echo '<td><h4>Προαπαιτούμενες μαθήματα</h4></td>';
            echo '<td><h4>Ημερομηνία δημοσίευσης</h4></td>';
            echo '<td><h4>Ημερομηνία ανάληψης θέματος</h4></td>';
            echo '<td><h4>Ημερομηνία ολοκλήρωσης</h4></td>';
            echo '<td><h4>Βαθμός</h4></td>';
            echo '</tr>';

            while ($row = $all_thesis->fetch_assoc()) {
                echo '<tr>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['title'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['description'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['target'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['student_number'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['student_number'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['student_knowledge'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . get_lesson_names_as_string_for_thesis($link, $row['id']) . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['publication_date'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['assignment_date'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['completion_date'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . $row['grade'] . '</h5>';
                echo '</td>';
                echo '<td>';
                echo '<form action="view_thesis.php" method="post" enctype="multipart/form-data">';
                echo '<input type="hidden" id="selected-thesis" name="selected-thesis" value="' . $row['id'] . '">';
                echo '<button type="submit" name="edit" class="btn btn-warning">Επεξεργασία</button>';
                echo '</form>';
                echo '</td>';
                echo '<td>';
                echo '<form action="view_thesis.php" method="post" enctype="multipart/form-data">';
                echo '<input type="hidden" id="selected-thesis" name="selected-thesis" value="' . $row['id'] . '">';
                echo '<button type="submit" name="pdf" class="btn btn-primary">Προς Γραμματεία</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        }
        ?>
    </table>

</div>
</body>
</html>