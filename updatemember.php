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
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-blog-header.php' );
$url = $_SERVER["HTTP_REFERER"];

if (isset($_POST["action"])&&($_POST["action"] == "add")) {
    function OpenCon()
        {
        $dbhost = "localhost";
        $dbuser = "uypwezpwts";
        $dbpass = "Zzzr89bSM7";
        $db = "uypwezpwts";
        

        $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("連接失敗: %s\n". $conn -> error);
        mysqli_query( $conn,"set names utf8"); // 修正中文亂碼問題

        return $conn;
        }
 
 
    function CloseCon($conn)
        {
        $conn -> close();
        }

        
        //$selectWpUser = $_POST["selectWpUser"]; //取會員
        //$paymoney     = $_POST['paymoney'];     //取金額 直接進入錢包
        //$couple       = $_POST['couple'];       //折扣代碼
        $selectWpUser     =mb_convert_encoding($_REQUEST['userid'] , "utf-8","auto");
        $paymoney         =mb_convert_encoding($_REQUEST['paymoney'] , "utf-8","auto");
        $Withholding_amount=mb_convert_encoding($_REQUEST['paymoney'] , "utf-8","auto");
        $one_Couple       =mb_convert_encoding($_REQUEST['couple'] , "utf-8","auto");
        $starttime        =date("Y-m-d");          //紀錄開始時間
        $endtime          =date('Y-m-d H:i:s', strtotime('+1 years'));
        $sqlcheck =  "SELECT * from one_member WHERE wp_user_id='$selectWpUser' || one_Couple='$one_Couple'";
        
        //計算比率 1000 3% 1500 6% 2000 10%
            if($paymoney >=1000 && $paymoney <= 1499){
              $Benefit ='3';
            }
            else if($paymoney >=1500 && $paymoney <= 1999){
              $Benefit = '6';
            }
            else if($paymoney >=2000){
              $Benefit = '10';
            }



            $url  =  $_SERVER["HTTP_REFERER"] ;  


if($paymoney<1000){

 echo "<script>alert('儲值金額須大於1000!!!');</script>";
               echo " <script   language = 'javascript'  type = 'text/javascript' > ";  
               echo " window.location.href = '$url' ";  
               echo " </script > ";  
}else{
        $conn = OpenCon();
        $res = mysqli_query($conn,$sqlcheck);
        if(mysqli_num_rows($res)>0){
            //更新動作
            echo "<script>alert('已有此編號 $selectWpUser 會員 或 折扣碼重複');</script>";
            echo " <script   language = 'javascript'  type = 'text/javascript' > ";  
            echo " window.location.href = '$url' ";  
            echo " </script > ";   
        }
        else{
            $sqlm = "INSERT INTO one_member (wp_user_id,one_Couple,one_CouplePercentage,one_Binding,one_Wellet,Withholding_amount,starttime,endtime) VALUES ('$selectWpUser','$one_Couple','$Benefit',null,'$paymoney','$Withholding_amount','$starttime','$endtime')";
            if ($conn->query($sqlm) === TRUE) {
              echo "<script>alert('編號 $selectWpUser 會員 註冊完成');</script>";
              echo " <script   language = 'javascript'  type = 'text/javascript' > ";  
              echo " window.location.href = '$url' ";  
              echo " </script > ";   
              } else {
                echo "發生錯誤: " . $sql . "<br>" . $conn->error;
              }
            //新增動作
        }
}
}

?>
</body>
</html>