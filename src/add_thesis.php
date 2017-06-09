<html>
<head>
    <?php
    include_once "page_parts/head.php";
    ?>

    <script>
        $(document).ready(function () {
            $("#add-lesson").click(function () {
                $('#mySelect')
                    .append($("<option></option>")
                        .attr("value", $('select[name=lessons-selector]').val())
                        .text($('select[name=lessons-selector]').val());
            });
        });
    </script>

</head>
<body class="container">
<?php
include_once "page_parts/header.php";
?>

<?php
include_once "page_parts/login_checker.php";
?>
<div class="page_content">
    <form action="register.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Τίτλος:</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Τίτλος">
        </div>
        <div class="form-group">
            <label for="student_number">Αριθμός Φοιτητών:</label>
            <input type="number" max="3" min="1" class="form-control" id="student_number" name="student_number"
                   placeholder="Αριθμός Φοιτητών">
        </div>
        <div class="form-group">
            <label for="target">Στόχος Διπλωματικής:</label>
            <input type="text" class="form-control" id="target" name="target" placeholder="Στόχος Διπλωματικής">
        </div>
        <div class="form-group">
            <label for="description">Συνοπτική Περιγραφή:</label>
            <input type="text" class="form-control" id="description" name="description"
                   placeholder="Συνοπτική Περιγραφή">
        </div>
        <div class="form-group">
            <label for="knowledge">Προαπαιτούμενες γνώσεις</label>
            <input type="text" class="form-control" id="knowledge" name="knowledge"
                   placeholder="Προαπαιτούμενες γνώσεις">
        </div>


        <div class="form-group">
            <label for="lessons-selector">Διαθέσιμα Μαθήματα:</label>
            <div class="input-group">
                <select class="form-control" name="lessons-selector" type="text" id="lessons-selector"
                        style="margin-top: 10px;margin-bottom: 10px">
                    <?php
                    $result = getLessonsFromDatabase($link);

                    while ($lesson = $result->fetch_assoc()) {
                        echo '<option value="' . $lesson["id"] . '">' . $lesson["name"] . '</option>';
                    }

                    ?>
                </select>
                <span class="input-group-btn">
                        <button type="button" id="add-lesson" class="btn btn-success form-control">Προσθήκη</button>
                    </span>
            </div>
        </div>

        <div class="form-group">
            <label for="lessons-selector">Επιλεγμένα Μαθήματα:</label>
            <div class="input-group">
                <select class="form-control" name="lessons-remove-selector" type="text" id="lessons-remove-selector"
                        style="margin-top: 10px;margin-bottom: 10px">
                </select>
                <span class="input-group-btn">
                        <button type="button" id="remove-lesson" class="btn btn-danger form-control">Αφαίρεση</button>
                    </span>
            </div>
        </div>

        <button type="submit" name="add" class="btn btn-primary">Προσθήκη</button>

    </form>
</div>
</body>
