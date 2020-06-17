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

$wp_user_id = mb_convert_encoding($_REQUEST['wp_user_id'], "utf-8", "auto");

$sqlcheck = "SELECT * from one_member WHERE wp_user_id='$wp_user_id'";

$res = mysqli_query($conn, $sqlcheck);

//判斷有沒有建立過此會員
if (mysqli_num_rows($res) > 0)
{
   //不做任何動作
}
else
{
  
  $sqladd = "INSERT INTO one_member (wp_user_id) VALUES ('$wp_user_id')";
  if ($conn->query($sqladd) === true)
    {

    }
    else
    {
        echo "新增會員失敗: " . $sqladd . "<br>" . $conn->error;
    }
   //建立新的會員資料，除會員編號，其餘空值
}

//輸入訂單資料
$couster_name = mb_convert_encoding($_REQUEST['frm_customer'], "utf-8", "auto");
$couster_tel = mb_convert_encoding($_REQUEST['frm_tel'], "utf-8", "auto");
$couster_service = mb_convert_encoding($_REQUEST['frm_rollno'], "utf-8", "auto");
$couster_cost = mb_convert_encoding($_REQUEST['frm_cost'], "utf-8", "auto");
$couster_staff = mb_convert_encoding($_REQUEST['frm_name'], "utf-8", "auto");
$couster_coupon = mb_convert_encoding($_REQUEST['frm_couple'], "utf-8", "auto");
$appointcode = mb_convert_encoding($_REQUEST['frm_id'], "utf-8", "auto");
$submission_date = mb_convert_encoding($_REQUEST['submission_date'], "utf-8", "auto");

$url = $_SERVER["HTTP_REFERER"];

$couplecheck = "SELECT wp_user_id  as 綁定會員 ,one_CouplePercentage  as 折扣, one_Wellet as 錢包 from one_member WHERE one_Couple='$couster_coupon'";

$res = mysqli_query($conn, $couplecheck);
if (mysqli_num_rows($res) > 0)
{
    while ($row = $res->fetch_assoc())
    {
        $one_Binding = $row['綁定會員'];
        $one_CouplePercentage = $row['折扣'];
        $nocouple = $couster_cost;
        $Benefit = $couster_cost * ($one_CouplePercentage / 100);
        $one_Binding_Wellet = $row['錢包'] + $Benefit;
        $couster_cost = $couster_cost * (1 - ($one_CouplePercentage / 100));
    }
}
else
{
    $couster_coupon = '';
    $nocouple = $couster_cost;
}

$sqlcheckcouple = "SELECT * from one_member WHERE wp_user_id='$wp_user_id' and one_Binding is null";
$rescouple = mysqli_query($conn, $sqlcheckcouple);
//判斷有沒有綁定任何折扣碼
if (mysqli_num_rows($rescouple)>0){
  $sqlupdatemember ="UPDATE one_member SET one_Binding ='$one_Binding' WHERE wp_user_id = '$wp_user_id'";
  if ($conn->query($sqlupdatemember) === true)
  {
    echo "更新會員折扣碼成功";
  }
  else
  {
      echo "更新會員折扣碼失敗: " . $sqlupdatemember . "<br>" . $conn->error;
  }
}
else{
  //echo "$wp_user_id.已綁定折扣碼";
}


$sqlcheckcklist = "SELECT * from checklist where appointcode =$appointcode";
$sqlinsertchecklist = "INSERT INTO checklist (wp_user_id,customer_name,customer_tel,customer_service,customer_cost,customer_staff,submission_date,appointcode,onepass) 
      VALUES ('$wp_user_id','$couster_name', '$couster_tel', '$couster_service','$nocouple','$couster_staff','$submission_date','$appointcode','N')";
$sqlupdatechecklist ="UPDATE checklist SET customer_cost = '$nocouple' where appointcode='$appointcode' ";
      
if (mysqli_num_rows($res) > 0)
{
        $rescheck = mysqli_query($conn, $sqlcheckcklist);
        //判斷有沒有建立過此訂單
        if (mysqli_num_rows($rescheck) > 0)
        {
          if ($conn->query($sqlupdatechecklist) === true)
          {
           //不做任何動作 返回頁面
          }
          else
          {
              echo "發生錯誤: " . $sqlupdatechecklist . "<br>" . $conn->error;
          }
        }
        else{
          if ($conn->query($sqlupdatechecklist) === true)
          {
           //不做任何動作 返回頁面
          }
          else
          {
              echo "發生錯誤: " . $sqlupdatechecklist . "<br>" . $conn->error;
          }
        }
        
}
else
{
  echo "do sth s";
}




CloseCon($conn);



?>
</body>
</html>