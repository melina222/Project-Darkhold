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

    <form action="search_thesis.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="keyword">Αναζήτηση δηπλωματικών:</label>
            <input required="required" type="text" class="form-control" id="keyword" name="keyword"
                   placeholder="Όνομα καθηγητή, λέξεις κλειδία χωρισμένα με κενό">
        </div>
        <center>
            <button type="submit" name="search" class="btn btn-primary">Αναζήτηση</button>
        </center>
    </form>
    <br>
    <br>
    <table class="table">
        <?php

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['apply'])) {

            $selected_thesis = mysqli_real_escape_string($link, $_POST['selected-thesis']);
            showAlertDialogMethod("selected thesis id" . $selected_thesis);

            insert_thesis_apply_for_student($link, $selected_thesis, $_SESSION['user_id']);

        }

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {

            $keyword = mysqli_real_escape_string($link, $_POST['keyword']);


            $all_thesis = get_thesis_with_keywords($link, $keyword);

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
                echo '<td><h4>Καθηγητής</h4></td>';
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
                    echo '<h5 id="align_start" style="">' . $row['student_knowledge'] . '</h5>';
                    echo '</td>';
                    echo '<td>';
                    echo '<h5 id="align_start" style="">' . get_lesson_names_as_string_for_thesis($link, $row['id']) . '</h5>';
                    echo '</td>';
                    echo '<td>';
                    echo '<h5 id="align_start" style="">' . get_full_teacher_name_for_thesis($link, $row['id']) . '</h5>';
                    echo '</td>';
                    echo '<td>';
                    echo '<h5 id="align_start" style="">' . $row['publication_date'] . '</h5>';
                    echo '</td>';
                    echo '<td>';
                    echo '<form action="search_thesis.php" method="post" enctype="multipart/form-data">';
                    echo ' <input type="hidden" id="selected-thesis" name="selected-thesis" value="' . $row['id'] . '">';
                    echo '<button type="submit" name="apply" class="btn btn-primary">Αίτηση</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
        }
        ?>
    </table>
</div>

</body>
</html>