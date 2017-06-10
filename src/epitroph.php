
  <html>

 <head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>


<body>
<div class="container">
<form action="epitroph.php" method="post">
<br>
    <input type="submit" id="submit6" name="submit6" value="Στείλε αίτηση αποδοχής ένταξης στην τριμελή επιτροπή">
	
</form>




</div>
</body>
</html>
<?php
$connect=new mysqli('localhost','root','','project');
 
if($connect->connect_error)
{
		die( 'Failed to connect');
}
else 
	echo 'connect worked ';
session_start();
   	  $_SESSION['id_role'] = $_GET["value1"];
	$id_role= $_SESSION['id_role'];
	$id_role="prof1234";
if (isset($_POST['name1']) && isset($_POST['name2'])&&isset($_POST['name3'])) {
	//	$adress='icsd16164@icsd.aegean.gr';//einai ths grammateias
	
	$token=$id_role;
	$adress=$_POST['name1'];
$send="O kathigiths me id :".$id_role. " kanei aithsh apodoxhs sthn epitroph .Apanthste edw: http://localhost/project/link.php?%20token=$token";
echo"<br>To μηνυμα που θα σταλεί είναι το εξής: '".$send."'";
echo "<p><a href='mail.php?  value1=$adress&value2=$send'>Αποστολή του link για την αποδοχή στο Πρώτο μέλος </a>";
  	$adress=$_POST['name2'];
echo "<p><a href='mail.php?  value1=$adress&value2=$send'>Αποστολή του link για την αποδοχή στο Πρώτο μέλος </a>";
 	$adress=$_POST['name3'];

echo "<p><a href='mail.php?  value1=$adress&value2=$send'>Αποστολή του link για την αποδοχή στο Πρώτο μέλος </a>";
 
	echo "<p><a href='kathigitis.php?  value1=$id_role'Αρχική </a>";
  }
if(isset($_POST['submit6']))
{   
 ?>

 <form role="form" action="" method="POST" enctype="multipart/form-data">


        <br>
      
        Mail Πρώτου Μέλους:
        <input type="text" name="name1">
        <br>
     
           Mail Δεύτερου Μέλους:
        <input type="text" name="name2">
        <br>
	   
           Mail Τρίτου Μέλους:
        <input type="text" name="name3">
        <br>
 <input type="submit" id="submit" name="submit" value="Αποθήκευση">
 </form>  
<?php
 }  
 ?>