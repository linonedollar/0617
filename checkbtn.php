<?php

require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-blog-header.php' );
header("Content-Type:text/html; charset=utf-8");
     
$couple= $_POST["data_id"];
$dbhost = "localhost";
$dbuser = "uypwezpwts";
$dbpass = "Zzzr89bSM7";
$db = "uypwezpwts";
$date = date("Y-m-d");
 
 //$date = "2020-06-01";
 $DS = " 00:00:00";
 $DE = " 23:59:59";
 $dateS =  $date.$DS;
 $dateE =  $date.$DE;
$currentuser = get_current_user_id();// 獲取當前user id 
// Create connection
$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);
mysqli_query( $conn,"SET CHARACTER SET UTF8");

$sqlcouple = "SELECT one_Couple,one_CouplePercentage From one_member where one_Couple = '$couple'";
$resultcouple = $conn->query($sqlcouple);

$out = '';
if ($resultcouple->num_rows > 0) {
  while($row = $resultcouple->fetch_assoc()) {
    $out .="折扣碼：". $row['one_Couple'] ." 可使用 ";
  }
}
else{
  $out .="折扣碼：". $couple ." 不可使用，或以綁定其他折扣碼";
}
echo $out;
$conn->close();
?>