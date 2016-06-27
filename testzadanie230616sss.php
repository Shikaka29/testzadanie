<html>
<head>
    <title></title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src='js/bootstrap.js'></script>
    <script src='js/bootstrap.min.js'></script>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <script src='js/jquery.dataTables.min.js'></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width">
  
</head>
<body>


<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"></a>
    </div>
 <ul class="nav navbar-nav">
<li><a href="testzadanie230616sss.php">Отправить email</a></li>
 <li><a href="testzadanie230616ss.php">Просмотреть email</a></li>
 </ul>
  </div>
</nav>



<div class="container">
    
    <div class="row">
        <div class="forma" align="center">
        <form id="comment_form" action="" method="post">
            <input type="email" required="" name="email" placeholder="Введите свой email" size="40"><br><br>
            <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Отправить"><br><br>
            <div class="g-recaptcha" data-callback="enableBtn" data-sitekey="6Le0kiMTAAAAACXHRc3VBCDUJdFvhrRxowqJqeuG"></div>
        </form>
        </div>
    </div>
</div>
  <script>
document.getElementById("submit").disabled = true;
function enableBtn(){
    document.getElementById("submit").disabled = false;
   }
    </script>
</body>

</html>


<?php
 if(!empty($_POST['email'])){
error_reporting(E_ALL & ~E_DEPRECATED);
require 'connect.php';

$email;
$captcha;

if(isset($_POST['email'])){
    $email=$_POST['email'];
}if(isset($_POST['g-recaptcha-response'])){
    $captcha=$_POST['g-recaptcha-response'];
}
if(!$captcha){
    echo '<h2>Please check the the captcha form.</h2>';
    exit;
}
$secretKey = "6Le0kiMTAAAAALv3sWPh3n4rdsicDc_HUBUB0RzK";
$ip = $_SERVER['REMOTE_ADDR'];
$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
$responseKeys = json_decode($response,true);
if(intval($responseKeys["success"]) !== 1) {
    echo '<h2></h2>';
} else {
    echo '<h2></h2>';

}


$email = $_REQUEST['email'];
$email = trim($_REQUEST['email']);
$email = stripslashes($_REQUEST['email']);
$email = strip_tags($_REQUEST['email']);
$email = htmlspecialchars($_REQUEST['email']);


$query="SELECT * FROM email WHERE email='$email'";
$result=mysql_query($query);

if((mysql_num_rows($result)==0)&&(intval($responseKeys["success"]) == 1) ){
    $insert_sql = "INSERT INTO email (email)" .
        "VALUES('{$email}');";
    mysql_query($insert_sql);
    echo '<div class="alert alert-success" style="text-align: center">&#1047;&#1072;&#1087;&#1080;&#1089;&#1100; &#1091;&#1089;&#1087;&#1077;&#1096;&#1085;&#1086; &#1089;&#1086;&#1079;&#1076;&#1072;&#1085;&#1072;</div>';
}else{
    echo '<div class="alert alert-warning" style="text-align: center">&#1058;&#1072;&#1082;&#1072;&#1103; &#1079;&#1072;&#1087;&#1080;&#1089;&#1100; &#1091;&#1078;&#1077; &#1089;&#1091;&#1097;&#1077;&#1089;&#1090;&#1074;&#1091;&#1077;&#1090;</div>';
}
if (empty($email)) {

}

}

?>