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

</div>
<html>

<div class="form-group">
    <label for="thesis-selector">Διαθέσιμες Διπλωματικές:</label>
    <div class="input-group">
        <select class="form-control" name="thesis-selector" type="text" id="thesis-selector"
                style="margin-top: 10px;margin-bottom: 10px">
            <?php
            $result = get_thesis_for_teacher_that_students_applied_for($link, $_SESSION['teacher_id']);
            while ($thesis = $result->fetch_assoc()) {
                echo '<option value="' . $thesis["id"] . '">' . $thesis["name"] . '</option>';
            }
            ?>
        </select>
    </div>
</div>

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages': ['gantt']});
        google.charts.setOnLoadCallback(drawChart);

        function daysToMilliseconds(days) {
            return days * 24 * 60 * 60 * 1000;
        }


        function drawChart() {

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Task ID');
            data.addColumn('string', 'Task Name');
            data.addColumn('date', 'Start Date');
            data.addColumn('date', 'End Date');
            data.addColumn('number', 'Duration');
            data.addColumn('number', 'Percent Complete');
            data.addColumn('string', 'Dependencies');

            data.addRows([
                ['Research', 'Find sources',
                    new Date(2015, 0, 1), new Date(2015, 0, 5), null, 100, null],
                ['Write', 'Write paper',
                    null, new Date(2015, 0, 9), daysToMilliseconds(3), 25, 'Research,Outline'],
                ['Cite', 'Create bibliography',
                    null, new Date(2015, 0, 7), daysToMilliseconds(1), 20, 'Research'],
                ['Complete', 'Hand in paper',
                    null, new Date(2015, 0, 10), daysToMilliseconds(1), 0, 'Cite,Write'],
                ['Outline', 'Outline paper',
                    null, new Date(2015, 0, 6), daysToMilliseconds(1), 100, 'Research']
            ]);

            var options = {
                height: 275
            };

            var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
<div id="chart_div"></div>
</body>
</html>
</body>
</html>
