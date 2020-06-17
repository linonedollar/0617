<html lang="zh_TW">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

  <title>Theoneoff</title>
  <style>
    * {
      font-size: 10pt;
    }
  </style>
</head>

<body>

  <?php

require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-blog-header.php' );
header("Content-Type:text/html; charset=utf-8");





if( current_user_can( 'manage_options' ) ) {
    echo "<nav class='navbar navbar-expand-lg navbar-light bg-light'>";
echo "<a class='navbar-brand' href='#'>Theoneoff</a>";
echo "<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>";
echo "<span class='navbar-toggler-icon'></span>";
echo "</button>";
echo "<div class='collapse navbar-collapse' id='navbarNav'>";
echo "<ul class='navbar-nav'>";
echo "<li class='nav-item '>";
echo "<a class='nav-link' href='adminorder.php'>訂單首頁</a>";
echo "</li>";
echo "<li class='nav-item '>";
echo "<a class='nav-link' href='controlorder.php'>訂單管理</a>";
echo "</li>";
echo "<li class='nav-item active'>";
echo "<a class='nav-link' href='member.php'>會員管理</a>";
echo "</li>";
echo "<li class='nav-item'>";
echo "<a class='nav-link' href='oneuser.php'>會員升級</a>";
echo "</li>";
echo "</ul>";
echo "</div>";
echo "</nav>";
    };


 $dbhost = "localhost";
 $dbuser = "uypwezpwts";
 $dbpass = "Zzzr89bSM7";
 $db = "uypwezpwts";
 $date = date("Y-m-d");
 $dateS =  $date.$DS;
 $dateE =  $date.$DE;
$currentuser = get_current_user_id();// 獲取當前user id 
// Create connection
$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);
mysqli_query( $conn,"SET CHARACTER SET UTF8");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}



$sqlappointment = "SELECT C.full_name as 會員名稱,C.phone as 電話 ,one.one_Couple	as 會員折扣碼, one.one_Wellet - one.Withholding_amount  as 會員虛擬錢包,one.endtime as 會員到期日 From one_member one
                  inner join `wp_bookme_pro_customers` C on C.wp_user_id = one.wp_user_id
                  where one_Wellet is not null
                  ";
$result = $conn->query($sqlappointment);

if ($result->num_rows > 0) {
  // output data of each row
  $out ="";
  
  echo "<div class='fixed-bottom text-center'>
        <div class='alert alert-primary' role='alert'> 今日 <a href='#' class='alert-link'>" .$date. "</a> 訂單 </div></div>";
  echo "<table class='table  table-bordered'> <thead class='thead-dark'> <tr><th>會員名稱</th><th>會員折扣碼</th><th>會員虛擬錢包</th><th>會員到期日</th></tr></thead>";
  
  while($row = $result->fetch_assoc()) {
            $out .= '<tr class="tr">';
            $out .= '<td class="td_num">' . $row['會員名稱']. '</td>';
            $out .= '<td class="td_couple">' . $row['會員折扣碼'] . '</td>';
            $out .= '<td class="td_Wellet">' . $row['會員虛擬錢包'] . '</td>';
            $out .= '<td class="td_endtime">' . $row['會員到期日'] . '</td>';
            $out .= '</tr>';
  }
  
  echo $out;
  echo "</table>";
  
} else {
  


}
$conn->close();
?>
</body>

</html>