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
        echo "建立會員失敗: " . $sqladd . "<br>" . $conn->error;
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
$showmessage = "";


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
    //判斷現在輸入的這個折扣碼是否有效，需要綁定
    if(mysqli_num_rows($res)>0){
        $sqlupdatemember ="UPDATE one_member SET one_Binding ='$one_Binding',give_CouplePercentage='$one_CouplePercentage' WHERE wp_user_id = '$wp_user_id'";
  if ($conn->query($sqlupdatemember) === true)
  {
    //$showmessage .= "更新會員折扣碼成功";
  }
  else
  {
      //echo "更新會員折扣碼失敗: " . $sqlupdatemember . "<br>" . $conn->error;
  }
    }
    else{
        //無效折扣碼 不做任何事情
    }
  
}
else{
      //$showmessage .= "$wp_user_id.已綁定其他折扣碼";
}





$alreadycouple = "SELECT give_CouplePercentage as 折扣 from one_member WHERE wp_user_id='$wp_user_id'";
$resalreadycouple = mysqli_query($conn, $alreadycouple);
if (mysqli_num_rows($resalreadycouple) > 0)
{
    while ($row = $resalreadycouple->fetch_assoc())
    {
        $one_CouplePercentage = $row['折扣'];
        
        $AlreadyBenefit = $couster_cost * ($one_CouplePercentage / 100);
        $nocouple = $couster_cost;
        
    }
}
else{
}



$sqlupdatechecklist ="UPDATE checklist SET customer_cost = '$nocouple' ,Benefit = '$Benefit'  where appointcode='$appointcode' ";
$sqlupdatechecklistnocouple ="UPDATE checklist SET customer_cost = '$nocouple',Benefit = '$AlreadyBenefit' where appointcode='$appointcode' ";


//確認是不是已經在管理者名單審核名單中
$sqlcheckcklist = "SELECT * from checklist where appointcode ='$appointcode'";
$sqlckeck = mysqli_query($conn, $sqlcheckcklist);


//確認是不是綁定折扣碼 且第一次消費
$sqlfirst = "SELECT one.* From one_member one INNER JOIN orderlist list on list.couster_id= one.wp_user_id WHERE wp_user_id='$wp_user_id' AND one_binding IS NOT NULL ";
$resfirst = mysqli_query($conn, $sqlfirst);



//已在管理員審核名單中，只可更新
if (mysqli_num_rows($sqlckeck) > 0)
{
  //代表已使用過折價券，則金額不折扣
  if(mysqli_num_rows($resfirst)>0){
      

         if ($conn->query($sqlupdatechecklistnocouple) === true)
          {
              $showmessage .= "已修正訂單金額 " .$couster_cost."（已使用過折價券，該次不折扣)";
          }
          else
          {
              echo "發生錯誤: " . $sqlupdatechecklistnocouple . "<br>" . $conn->error;
          }
  }
  else{
          if ($conn->query($sqlupdatechecklist) === true)
          {
              $showmessage .= "已修正訂單金額 " .$couster_cost."（已折扣：".$one_CouplePercentage."%)";
          }
          else
          {
              echo "發生錯誤: " . $sqlupdatechecklist . "<br>" . $conn->error;
          }
  }
}
else
{
  if(mysqli_num_rows($resfirst)>0){
      
//無折扣
$sqladdchecknocouple = "INSERT INTO checklist (wp_user_id,customer_name,customer_tel,customer_service,customer_cost,Benefit,customer_staff,submission_date,appointcode,onepass) 
VALUES ('$wp_user_id','$couster_name', '$couster_tel', '$couster_service','$nocouple','$AlreadyBenefit','$couster_staff','$submission_date','$appointcode','N')";


         if ($conn->query($sqladdchecknocouple) === true)
          {
              $showmessage .= "已輸入訂單金額 " .$couster_cost."（已使用過折價券，該次不折扣)";
          }
          else
          {
              echo "發生錯誤: " . $sqladdchecknocouple . "<br>" . $conn->error;
          }
  }
  else{
      //有折扣 第一次消費
$sqladdcheckhavecouple = "INSERT INTO checklist (wp_user_id,customer_name,customer_tel,customer_service,customer_cost,Benefit,customer_staff,submission_date,appointcode,onepass) 
VALUES ('$wp_user_id','$couster_name', '$couster_tel', '$couster_service','$couster_cost','$Benefit','$couster_staff','$submission_date','$appointcode','N')";

          if ($conn->query($sqladdcheckhavecouple) === true)
          {
              $showmessage .= "已輸入訂單金額 " .$couster_cost."（已折扣：".$one_CouplePercentage."%)";
          }
          else
          {
              echo "發生錯誤: " . $sqladdcheckhavecouple . "<br>" . $conn->error;
          }
  }
}

 echo "<script>alert(' $showmessage');</script>";
 echo " <script   language = 'javascript'  type = 'text/javascript' > ";  
 echo " window.location.href = '$url' ";  
 echo " </script > ";  


CloseCon($conn);



?>
</body>
</html>