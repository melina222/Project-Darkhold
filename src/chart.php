<?php

$query = "SELECT user.fname , user.lname, COUNT(diplwmatikh.role_id) AS 'Arithmos diplwmatikwn' FROM `diplwmatikh`,user where user.role_id = diplwmatikh.role_id GROUP BY diplwmatikh.role_id ORDER BY COUNT(diplwmatikh.role_id) DESC";
$query1 = "SELECT AVG(diplwmatikh.vathmos) as 'Mesos oros vathmologiwn',user.lname FROM `diplwmatikh`,user 
WHERE diplwmatikh.role_id=user.role_id 
GROUP BY diplwmatikh.role_id";
$query2 = "SELECT user.fname , user.lname,year(diplwmatikh.date_olok) as 'etos', 
COUNT(diplwmatikh.role_id) AS 'Arithmos diplwmatikwn ana etos' FROM `diplwmatikh`,user where user.role_id = diplwmatikh.role_id GROUP BY diplwmatikh.role_id,year(diplwmatikh.date_olok)
 ORDER BY COUNT(diplwmatikh.role_id) DESC";
$query3 = "SELECT round(AVG(DATEDIFF(date_olok,date_an))/7) as 'meso diastima',diplwmatikh.role_id,diplwmatikh.date_an,diplwmatikh.date_olok,user.lname 
FROM diplwmatikh,user where user.role_id=diplwmatikh.role_id GROUP BY role_id";

$result = mysqli_query($link, $query);
$result1 = mysqli_query($link, $query1);
$result2 = mysqli_query($link, $query2);
$result3 = mysqli_query($link, $query3);
$rows = array();
$rows1 = array();
$rows2 = array();
$rows3 = array();
// loop over the results of the query and input data into data structure
while ($query = mysqli_fetch_array($result)) {
//    $f_name = $query['f_name'];
//    $l_name = $query['l_name'];
    $count = $query['Arithmos diplwmatikwn'];
    $name = $query['lname'];

    // input data into data structure
    // typecast count as integer so it doesn't get interpreted as a string
    $rows[] = array($name, (int)$count);
}
$data = json_encode($rows);

while ($query1 = mysqli_fetch_array($result1)) {
//    $f_name = $query['f_name'];
//    $l_name = $query['l_name'];
    $count1 = $query1['Mesos oros vathmologiwn'];
    $name1 = $query1['lname'];

    // input data into data structure
    // typecast count as integer so it doesn't get interpreted as a string
    $rows1[] = array($name1, (int)$count1);
}
$data1 = json_encode($rows1);

while ($query2 = mysqli_fetch_array($result2)) {
//    $f_name = $query['f_name'];
//    $l_name = $query['l_name'];
    $count2 = $query2['Arithmos diplwmatikwn ana etos'];
    $name2 = $query2['etos'];
//    $name_k = $query2['lname'];

    $rows2[] = array($name2, (int)$count2);
}
$data2 = json_encode($rows2);

while ($query3 = mysqli_fetch_array($result3)) {
//    $f_name = $query['f_name'];
//    $l_name = $query['l_name'];
    $count3 = $query3['meso diastima'];
    $name3 = $query3['lname'];

    // input data into data structure
    // typecast count as integer so it doesn't get interpreted as a string
    $rows3[] = array($name3, (int)$count3);
}
$data3 = json_encode($rows3);
?>
<html>

<head>

    <?php
    include_once "page_parts/head.php";
    ?>


    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

        // Load the Visualization API and the piechart package.
        google.load('visualization', '1.0', {'packages': ['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.setOnLoadCallback(drawChart);
        google.setOnLoadCallback(drawChart1);
        google.setOnLoadCallback(drawChart2);
        google.setOnLoadCallback(drawChart3);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'fname');
            data.addColumn('number', 'Συνολο Διπλωματικων');
            data.addRows(<?php echo $data; ?>);


            // Set chart options
            var options = {
                'title': 'Συνολο Διπλωματικων ανα Καθηγητη', 'width': 800,
                'height': 400
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_channel'));
            chart.draw(data, options);
        }

        function drawChart1() {


            // Create the data table.
            var data1 = new google.visualization.DataTable();
            data1.addColumn('string', 'fname');
            data1.addColumn('number', 'Μεσος ορος Βαθμολογιων');
            data1.addRows(<?php echo $data1; ?>);

            // Set chart options
            var options1 = {
                'title': 'Μεσος ορος Βαθμολογιων Πτυχιακων ανα Καθηγητη', 'width': 800,
                'height': 400
            };

            // Instantiate and draw our chart, passing in some options.
            var chart1 = new google.visualization.ColumnChart(document.getElementById('chart_channel2'));
            chart1.draw(data1, options1);
        }

        function drawChart2() {

            // Create the data table.
            var data2 = new google.visualization.DataTable();


//            data2.addColumn('number', 'etos');


            data2.addColumn('string', 'lname');
            data2.addColumn('number', 'Συνολο Διπλωματικων ανα ετος');
            data2.addRows(<?php echo $data2; ?>);

            // Set chart options
            var options2 = {
                'title': 'Συνολο Διπλωματικων ανα ετος', 'width': 800,
                'height': 400
            };

            // Instantiate and draw our chart, passing in some options.
            var chart2 = new google.visualization.ColumnChart(document.getElementById('chart_channel3'));
            chart2.draw(data2, options2);
        }

        function drawChart3() {

            // Create the data table.
            var data3 = new google.visualization.DataTable();


//            data2.addColumn('number', 'etos');


            data3.addColumn('string', 'lname');
            data3.addColumn('number', 'Meso diastima');
            data3.addRows(<?php echo $data3; ?>);

            // Set chart options
            var options3 = {
                'title': 'Mέσο διάστημα ολοκλήρωσης πτυχιακής(σε εβδομάδες) ανά καθηγητή', 'width': 800,
                'height': 400
            };

            // Instantiate and draw our chart, passing in some options.
            var chart3 = new google.visualization.ColumnChart(document.getElementById('chart_channel4'));
            chart3.draw(data3, options3);
        }
    </script>
</head>
<body class="conatainer">
<?php
include_once "page_parts/header.php";
?>

<?php
include_once "page_parts/login_checker.php";
?>

<div class="page_content">
    <!--Div that will hold the pie chart-->
    <div id="chart_channel" align="center"></div>
    <div id="chart_channel3" align="center"></div>
    <div id="chart_channel2" align="center"></div>
    <div id="chart_channel4" align="center"></div>

</div>
</body>

</html>