<html lang="zh_TW">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
     <title>Theoneoff</title>
  </head>
  <body>
  <?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/wp-blog-header.php');
function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "uypwezpwts";
    $dbpass = "Zzzr89bSM7";
    $db = "uypwezpwts";
    $date = new DateTime('now');

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("連接失敗: %s\n" . $conn->error);
    mysqli_query($conn, "set names utf8"); // 修正中文亂碼問題
    return $conn;
}

function CloseCon($conn)
{
    $conn->close();
}

$conn = OpenCon();
//輸入 one_member


//輸入訂單資料
$couster_name = mb_convert_encoding($_REQUEST['frm_customer'], "utf-8", "auto");
$couster_tel = mb_convert_encoding($_REQUEST['frm_tel'], "utf-8", "auto");
$couster_service = mb_convert_encoding($_REQUEST['frm_rollno'], "utf-8", "auto");
$couster_cost = mb_convert_encoding($_REQUEST['frm_cost'], "utf-8", "auto");
$couster_staff = mb_convert_encoding($_REQUEST['frm_name'], "utf-8", "auto");
$Benefit = mb_convert_encoding($_REQUEST['Benefit'], "utf-8", "auto");
$appointcode = mb_convert_encoding($_REQUEST['frm_id'], "utf-8", "auto");
$submission_date = mb_convert_encoding($_REQUEST['submission_date'], "utf-8", "auto");
$binding = mb_convert_encoding($_REQUEST['binding'], "utf-8", "auto");
$wp_user_id = mb_convert_encoding($_REQUEST['wp_user_id'], "utf-8", "auto");
$url = $_SERVER["HTTP_REFERER"];


$sqlupdatechecklist ="UPDATE checklist SET onepass = 'Y'  where appointcode='$appointcode' ";
$conn->query($sqlupdatechecklist);

$sqlbind = "SELECT one_Wellet as 錢包 from one_member WHERE wp_user_id='$binding'";

$resalreadycouple = mysqli_query($conn, $sqlbind);
if (mysqli_num_rows($resalreadycouple) > 0)
{
    while ($row = $resalreadycouple->fetch_assoc())
    {
        $one_Wellet = $row['錢包'];
        $one_Wellet = $Benefit +$one_Wellet;
    }
}
else{
}


$sqlupdatemember = "UPDATE one_member SET one_Wellet = '$one_Wellet' where wp_user_id ='$binding'";
$conn->query($sqlupdatemember);

$sql = "INSERT INTO orderlist (couster_name,couster_id,couster_tel,couster_service,couster_cost,couster_couplecost,couster_staff,submission_date,appointcode,userid) 
VALUES ('$couster_name','$wp_user_id','$couster_tel', '$couster_service', '$couster_cost','$Benefit','$couster_staff','$submission_date','$appointcode','$binding') ";

if ($conn->query($sql) === TRUE) {
  echo "<script>alert('編號 $appointcode 訂單已完成');</script>";
  echo " <script   language = 'javascript'  type = 'text/javascript' > ";  
  echo " window.location.href = '$url' ";  
  echo " </script > ";   
  } else {
    echo "發生錯誤: " . $sql . "<br>" . $conn->error;
  }

CloseCon($conn);



?>
</body>
</html>