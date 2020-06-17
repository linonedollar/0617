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
  echo "<li class='nav-item active'>";
  echo "<a class='nav-link' href='adminorder.php'>訂單首頁 <span class='sr-only'>(current)</span></a>";
  echo "</li>";
  echo "<li class='nav-item'>";
  echo "<a class='nav-link' href='controlorder.php'>訂單管理</a>";
  echo "</li>";
  echo "<li class='nav-item'>";
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
 
 $date = "2020-06-15";
 $DS = " 00:00:00";
 $DE = " 23:59:59";
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



$sqlappointment = "SELECT App.id as 編號, App.start_date as 時間, Services.title as 服務項目, Staff.full_name as 設計師, C.full_name as 顧客姓名 , C.phone as 電話 , C.wp_user_id as 顧客ID ,CApp.custom_fields as 優惠碼 , cklist.customer_cost as 消費金額
                  FROM `wp_bookme_pro_appointments` as App
                  inner join `wp_bookme_pro_staff` Staff on App.staff_id = Staff.id
                  inner join `wp_bookme_pro_services` Services on Services.id = App.service_id
                  inner join `wp_bookme_pro_customer_appointments` CApp on CApp.appointment_id = App.id
                  inner join `wp_bookme_pro_customers` C on C.id = CApp.customer_id
                  left join `checklist` cklist on cklist.appointcode = App.id
                  where App.start_date BETWEEN '$dateS ' AND '$dateE'
                  and NOT EXISTS (SELECT appointcode	 FROM orderlist Where orderlist.appointcode = App.id)
                  and Staff.wp_user_id = $currentuser and cklist.onepass is null || App.start_date BETWEEN '$dateS ' AND '$dateE'
                  and NOT EXISTS (SELECT appointcode	 FROM orderlist Where orderlist.appointcode = App.id)
                  and Staff.wp_user_id = $currentuser and cklist.onepass ='N';
                  ";
$result = $conn->query($sqlappointment);

if ($result->num_rows > 0) {
  // output data of each row
  $out ="";
  
  echo "<div class='fixed-bottom text-center'>
        <div class='alert alert-primary' role='alert'> 今日 <a href='#' class='alert-link'>" .$date. "</a> 訂單 </div></div>";
  echo "<table class='table  table-bordered'> <thead class='thead-dark'> <tr><th>設計師</th><th>服務項目</th><th>顧客</th><th>連絡電話</th><th>會員ID</th><th>折扣碼</th><th>消費金額</th><th>操作</th></tr></thead>";
  
  while($row = $result->fetch_assoc()) {
            $out .= '<tr class="tr">';
            $out .= '<td class="td_num" style="display:none;">' . $row['編號']. '</td>';
            $out .= '<td class="td_name">' . $row['設計師'] . '</td>';
            $out .= '<td class="td_service">' . $row['服務項目'] . '</td>';
            $out .= '<td class="td_customer">' . $row['顧客姓名'] . '</td>';
            $out .= '<td class="td_tel">' . $row['電話'] . '</td>';
            $out .= '<td class="wp_user_id">' . $row['顧客ID'] . '</td>';
            $jsoncouple = $row['優惠碼'];
            $jsoncouple = substr($jsoncouple,0,-1);
            $jsoncouple = substr($jsoncouple,1);
            $jsoncouple = json_decode($jsoncouple);
            $tdcouple = $jsoncouple -> {'value'};
            $out .= '<td class="td_couple">'.$tdcouple. '</td>';
            
            $out .= '<td class="cost">' . $row['消費金額'] . '</td>';
            $out .= "<td><button class='td_btn btn btn-outline-secondary'>修改</button> </td>";
            $out .= '</tr>';
  }
  
  echo $out;
  echo "</table>";
  
} else {
  
  echo "<div class='fixed-bottom text-center'>
        <div class='alert alert-primary' role='alert'> 今日 <a href='#' class='alert-link'>" .$date. "</a> 訂單 </div></div>";
  echo "
  <div class='jumbotron jumbotron-fluid alert alert-primary'>
  <div class='container text-center'>
    <h1>您已完成今日所有訂單</h1>
  </div>
</div>";


}
$conn->close();
?>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>

        </div>
        <div class="modal-body">
          <form id="updateValues" action="update.php" method="post" enctype="multipart/form-data" accept-charset="UTF-8"
            class="form">
            <div class="form-group">
              <label for="name">設計師</label>
              <input type="hidden" class="form-control" name="frm_name" id="frm_name">
              <input type="text" class="form-control" name="name" disabled id="frm_names">
            </div>
            <div class="form-group">
              <label for="rollno">服務項目</label>
              <input type="hidden" class="form-control" name="frm_rollno" id="frm_rollno">
              <input type="text" class="form-control" name="rollno" disabled id="frm_rollnos">
            </div>
            <div class="form-group">
              <label for="customer">顧客</label>
              <input type="hidden" class="form-control" name="frm_customer" id="frm_customer">
              <input type="text" class="form-control" name="customer" disabled id="frm_customers">
            </div>
            <div class="form-group">
              <label for="tel">連絡電話</label>
              <input type="hidden" class="form-control" name="frm_tel" id="frm_tel">
              <input type="text" class="form-control" name="tel" disabled id="frm_tels">
            </div>
            <div class="form-group">
              <label for="couple">折扣碼</label>
              <input type="text" class="form-control" name="frm_couple" id="frm_couple"></input>
              <button type="button" class="btn btn-info checkbtn">確認折扣碼</button>
            </div>
            <div class="form-group">
              <label for="cost">價格</label>
              <input type="number"" class=" form-control" name="frm_cost" data-toggle="validator" id="frm_cost">
            </div>
            <div class="form-group">
              <input type="hidden" name="submission_date" id="submission_date" value="<?php echo $date ?>">
            </div>
            <input type="hidden" name="wp_user_id" id="wp_user_id">
            <input type="hidden" name="frm_id" id="frm_id">
            <input type="submit" class="btn btn-primary btn-custom" value="輸入訂單">
          </form>
          <form>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.1.1.min.js" />
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
  </script>
  <script>
    $('.td_btn').click(function () {
      var $row = $(this).closest("tr"); // Find the row
      var num = $row.find('.td_num').text();
      var name = $row.find('.td_name').text();
      var service = $row.find('.td_service').text();
      var customer = $row.find('.td_customer').text();
      var tel = $row.find('.td_tel').text();
      var userid = $row.find('.wp_user_id').text();
      var couple = $row.find('.td_couple').text();
      var modaluserid = document.getElementById("wp_user_id");
      modaluserid.value = userid;
      var modalname = document.getElementById("frm_name");
      modalname.value = name;
      var modalnames = document.getElementById("frm_names");
      modalnames.value = name;
      var modalservice = document.getElementById("frm_rollno");
      modalservice.value = service;
      var modalservices = document.getElementById("frm_rollnos");
      modalservices.value = service;
      var modalcustomer = document.getElementById("frm_customer");
      modalcustomer.value = customer;
      var modalcustomers = document.getElementById("frm_customers");
      modalcustomers.value = customer;
      var modalcouple = document.getElementById("frm_couple");
      modalcouple.value = couple;
      var modlaltel = document.getElementById("frm_tel");
      modlaltel.value = tel;
      var modlaltels = document.getElementById("frm_tels");
      modlaltels.value = tel;
      var frm_id = document.getElementById("frm_id");
      frm_id.value = num;

      $('#myModal').modal('show');
    });
    $('.checkbtn').click(function () {
      var result = false; //預設值

      $.ajax({
        url: "../checkbtn.php",
        type: 'post',
        crossDomain: true,
        data: {
          data_id: $('#frm_couple').val()
        },
        complete: function (XMLHttpRequest, status, error) {
          alert(XMLHttpRequest.responseText);
        },
        error: function (XMLHttpRequest, status, error) {
          console.log(XMLHttpRequest.responseText);
        }
      });


      // $.ajax({
      //     url: 'checkbtn.php',
      //     type: 'POST',
      //     data: { 
      //         data_id: $('#frm_couple').val(),
      //     },
      //     dataType: 'JSON',
      //     Success: function (data) {
      //         }
      //     },
      //     Error: function(XMLHttpRequest, status, error) {
      //         console.log(XMLHttpRequest.responseText);
      //     });
      // });
    });
  </script>
</body>

</html>