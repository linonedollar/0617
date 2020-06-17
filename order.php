<?php
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';


function OpenCon()
 {
 $dbhost = "localhost";
 $dbuser = "uypwezpwts";
 $dbpass = "Zzzr89bSM7";
 $db = "uypwezpwts";
 $date = new DateTime('now');

 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

 
 return $conn;
 }
 
 
function CloseCon($conn)
 {
 $conn -> close();
 }
  
 $conn = OpenCon();
 $couster_name     =iconv("utf-8","Big5", $_REQUEST['couster_name']);
 $couster_tel      =iconv("utf-8","Big5", $_REQUEST['couster_tel']);
 $couster_service  =iconv("utf-8","Big5", $_REQUEST['couster_service']);
 $couster_cost     =iconv("utf-8","Big5", $_REQUEST['couster_cost']);
 $couster_staff    =iconv("utf-8","Big5", $_REQUEST['couster_staff']);
 $couster_coupon   =iconv("utf-8","Big5", $_REQUEST['couster_coupon']);

 $sql = "INSERT INTO orderlist (couster_name, couster_tel, couster_service,couster_cost,couster_staff,couster_coupon,submission_date)
 VALUES ('$couster_name', '$couster_tel', '$couster_service','$couster_cost','$couster_staff','$couster_coupon','$date')";
  
 if ($conn->query($sql) === TRUE) {
     echo "<script>alert(' $couster_name');location.href='".$_SERVER["HTTP_REFERER"]."';</script>"; 
 } else {
     echo "Error: " . $sql . "<br>" . $conn->error;
 }
  




CloseCon($conn);

?>