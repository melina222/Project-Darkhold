
<?php
	  session_start();
	 // if(isset($_GET[]){
	 $_SESSION['title'] = $_GET["value1"];
	$title=$_SESSION['title'];

   	  $_SESSION['id_role'] = $_GET["value2"];
	$title2=$_SESSION['id_role'];
   echo "<br>Chat για την διπλωματική".$title;
     echo "<br> id user : ".$title2;
	  
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <link href="Style.css" type="text/css" rel="stylesheet"/>


 <title>ΣΥΝΟΜΙΛΙΑ ΔΙΠΛΩΜΑΤΙΚΉΣ</title>


 </head>
 <body>
   <h2>Καλωσήρθατε,<span style="color:blue"><?php echo $_SESSION['id_role']; ?></span></h2>
     </br></br>
	  
		<div id="chatbox" name="chatbox">
        </div>
<form role="form" action="" method="POST" enctype="multipart/form-data">


       <br>
        Path :
        <input type="text" name="path">
        <br>
	

 <input  type="submit" id="submit" name="submit" value="Αποθήκευση" onClick= "loadxml();">
<script type="text/javascript">
//document.getElementsByClassName('.form')[0].addEventListe‌​ner('submit',functio‌​n(){ alert('Form submitted'); return false; });

$("#clickMe").bind('click', function () {
	var el = document.getElementById("clickMe");
		    alert("hello".$el);
    var txtArea = $("#txtArea").val();
 $.ajax({
			type:"POST",
			url:"InsertMessage.php",
			data:{txtArea:txtArea}
			success: function(data){
				 $("#chatbox").html(data); 
                  alert(data);				
                $("#chatbox").load("DispalyMessages.php")			
				$("#txtArea").val(""); //Insert chat log into the #chatbox div				
		  	}
			 error: function(){
                 alert('there was an error, write your error handling code here.');
             }
			   return false;
		});

//setInterval(function(){
//	$("#chatbox").load("DispalayMessages.php");		
//}//,1400);

	 };)
</script>";
    </form>


	</body>
	</html>
	