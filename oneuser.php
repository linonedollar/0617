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
            body {
            margin: 0;
            color: #6a6f8c;
            background: #c8c8c8;
            font: 600 16px/18px 'Open Sans', sans-serif;
            }
            *,
            :after,
            :before {
            box-sizing: border-box
            }
            .clearfix:after,
            .clearfix:before {
            content: '';
            display: table
            }
            .clearfix:after {
            clear: both;
            display: block
            }
            a {
            color: inherit;
            text-decoration: none
            }
            .login-wrap {
            width: 100%;
            margin: auto;
            max-width: 525px;
            min-height: 670px;
            position: relative;
            background: url(https://raw.githubusercontent.com/khadkamhn/day-01-login-form/master/img/bg.jpg) no-repeat center;
            box-shadow: 0 12px 15px 0 rgba(0, 0, 0, .24), 0 17px 50px 0 rgba(0, 0, 0, .19);
            }
            .login-html {
            width: 100%;
            height: 100%;
            position: absolute;
            padding: 90px 70px 50px 70px;
            background: rgba(40, 57, 101, .9);
            }
            .login-html .sign-in-htm,
            .login-html .sign-up-htm {
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            position: absolute;
            transform: rotateY(180deg);
            backface-visibility: hidden;
            transition: all .4s linear;
            }
            .login-html .sign-in,
            .login-html .sign-up,
            .login-form .group .check {
            display: none;
            }
            .login-html .tab,
            .login-form .group .label,
            .login-form .group .button {
            text-transform: uppercase;
            }
            .login-html .tab {
            font-size: 22px;
            margin-right: 15px;
            padding-bottom: 5px;
            margin: 0 15px 10px 0;
            display: inline-block;
            border-bottom: 2px solid transparent;
            }
            .login-html .sign-in:checked+.tab,
            .login-html .sign-up:checked+.tab {
            color: #fff;
            border-color: #1161ee;
            }
            .login-form {
            min-height: 345px;
            position: relative;
            perspective: 1000px;
            transform-style: preserve-3d;
            }
            .login-form .group {
            margin-bottom: 15px;
            }
            .login-form .group .label,
            .login-form .group .input,
            .login-form .group .button {
            width: 100%;
            color: black;
            font-weight:bolder;
            display: block;
            }
            .login-form .group .input,
            .login-form .group .button {
            border: none;
            padding: 15px 20px;
            border-radius: 25px;
            background: rgba(255, 255, 255, .5);
            }
            .login-form .group input[data-type="password"] {
            text-security: circle;
            -webkit-text-security: circle;
            }
            .login-form .group .label {
            color: #aaa;
            font-size: 12px;
            }
            .login-form .group .button {
            background: #1161ee;
            }
            .login-form .group label .icon {
            width: 15px;
            height: 15px;
            border-radius: 2px;
            position: relative;
            display: inline-block;
            background: rgba(255, 255, 255, .1);
            }
            .login-form .group label .icon:before,
            .login-form .group label .icon:after {
            content: '';
            width: 10px;
            height: 2px;
            background: #fff;
            position: absolute;
            transition: all .2s ease-in-out 0s;
            }
            .login-form .group label .icon:before {
            left: 3px;
            width: 5px;
            bottom: 6px;
            transform: scale(0) rotate(0);
            }
            .login-form .group label .icon:after {
            top: 6px;
            right: 0;
            transform: scale(0) rotate(0);
            }
            .login-form .group .check:checked+label {
            color: #fff;
            }
            .login-form .group .check:checked+label .icon {
            background: #1161ee;
            }
            .login-form .group .check:checked+label .icon:before {
            transform: scale(1) rotate(45deg);
            }
            .login-form .group .check:checked+label .icon:after {
            transform: scale(1) rotate(-45deg);
            }
            .login-html .sign-in:checked+.tab+.sign-up+.tab+.login-form .sign-in-htm {
            transform: rotate(0);
            }
            .login-html .sign-up:checked+.tab+.login-form .sign-up-htm {
            transform: rotate(0);
            }
            .hr {
            height: 2px;
            margin: 60px 0 50px 0;
            background: rgba(255, 255, 255, .2);
            }
            .foot-lnk {
            text-align: center;
            }
            </style>
        </head>
        <body>
            <?php
            require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-blog-header.php' );
                 if( current_user_can( 'manage_options' ) ) {
}
else{
     echo "<script>alert('無權限');</script>";
               echo " <script   language = 'javascript'  type = 'text/javascript' > ";  
               echo " window.location.href = 'https://theoneoff.prosgroup.info/' ";  
               echo " </script > ";
}

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
echo "<li class='nav-item active'>";
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
            ?>

            <div class="login-wrap">
                <div class="login-html">
                    <input id="tab-2" type="radio" name="tab" class="sign-up" checked><label for="tab-2"
                    class="tab">付費會員資訊輸入</label>
                    <div class="login-form">
                        <div class="sign-up-htm">
                            <form id="updateValues" action="updatemember.php" method="post"  enctype="multipart/form-data" accept-charset="UTF-8" class="form">
                                <input type="hidden" name="action" value="add">
                                
                                <div class="group">
                                    <label for="user" class="label">請選擇帳號</label>
                                    <input list="cookies" name="userid" placeholder="請輸入會員信箱"/ class="input">
                                    <datalist name="selectWpUser"  id="cookies">
                                    <?php
                                    $blogusers = get_users( [ 'role__in' => [  'subscriber' ] ] );
                                    // Array of WP_User objects.
                                    foreach ( $blogusers as $user ) {
                                    echo '<option value="'.esc_html($user->ID).'">' . esc_html( $user->user_email) . '</option>';
                                    }
                                    ?>
                                    </datalist>
                                    
                                    <input id="user" type="hidden" class="input">
                                </div>
                                <div class="group">
                                    <label for="paymoney" class="label">付費金額</label>
                                    <input id="paymoney" name="paymoney" type="text" class="input" data-type="text">
                                </div>
                                <div class="group">
                                    <label for="couple" class="label">會員折扣碼</label>
                                    <input id="couple" name="couple" type="text" class="input" data-type="text">
                                </div>
                                <div class="group">
                                    <input type="submit" class="button" value="更新會員">
                                </div>
                                <div class="hr"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            
            
        </body>
    </html>