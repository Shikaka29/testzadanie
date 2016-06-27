<script src='js/bootstrap.js'></script>
<script src='js/bootstrap.min.js'></script>
<link href="css/bootstrap.css" rel="stylesheet">
<script src='js/jquery.dataTables.min.js'></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width">

<form name="search" method="post" action="searchview.php">
    <input type="search" minlength="3"  required="" id="text" data-callback="enableBtn" name="query" placeholder="Поиск">
    <button class="btn btn-primary"  id="submit" type="submit">Найти</button>
</form>

<style>


    a{
        padding-left: 5px;
        padding-right: 5px;
     
    }
    .table{
        width: auto!important;
        margin:0 auto;
    }
</style>

<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'connect.php';


$qr_result = mysql_query("select * from email") or trigger_error("SQL", E_USER_ERROR);
$num_rows = mysql_num_rows( $qr_result );

if(!empty($_POST['search'])) {
    $search = mysql_query("select * from `email` where `email` like '%" . mysql_real_escape_string($_POST['search']) . "%'");
}

echo '<div class="alert alert-info" style="text-align: center"> Количество записей : '. $num_rows.'  </div>';




// database connection info
$conn = mysql_connect('mysql.hostinger.ru','u661420716_test','123123') or trigger_error("SQL", E_USER_ERROR);
$db = mysql_select_db('u661420716_test',$conn) or trigger_error("SQL", E_USER_ERROR);

$sql = "SELECT COUNT(*) FROM email";
$result = mysql_query($sql, $conn) or trigger_error("SQL", E_USER_ERROR);
$r = mysql_fetch_row($result);
$numrows = $r[0];
$rowsperpage = 5;
$totalpages = ceil($numrows / $rowsperpage);

if (isset($_GET['p']) && is_numeric($_GET['p'])) {
    // cast var as int
    $p = (int) $_GET['p'];
} else {
    // default page num
    $p = 1;
} // end if

// if current page is greater than total pages...
if ($p > $totalpages) {
    // set current page to last page
    $p = $totalpages;
} // end if
// if current page is less than first page...
if ($p < 1) {
    // set current page to first page
    $p = 1;
} // end if

$offset = ($p - 1) * $rowsperpage;

$sql = "SELECT email FROM email LIMIT $offset, $rowsperpage";
$result = mysql_query($sql, $conn) or trigger_error("SQL", E_USER_ERROR);


echo '<table class="table table-hover" style="border:1px solid whitesmoke;margin-top:20px;">';
echo '<tr>';
echo '<th>email</th>';
echo '</tr>';
while ($list = mysql_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $list['email'] . '</td>';
        echo '</tr>';
} 

$range = 3;

 if ($p > 1) {
    echo " <a  href='{$_SERVER['PHP_SELF']}?p=1'><<</a> ";
    $prevpage = $p - 1;
    echo " <a  href='{$_SERVER['PHP_SELF']}?p=$prevpage'><</a> ";
}

for ($x = ($p - $range); $x < (($p + $range) + 1); $x++) {
    if (($x > 0) && ($x <= $totalpages)) {
        if ($x == $p) {
            echo " [<b>$x</b>] ";
        } else {
            echo " <a href='{$_SERVER['PHP_SELF']}?p=$x'>$x</a> ";
        }
    }
}

if ($p != $totalpages) {
    $nextpage = $p + 1;
    echo "<a href='{$_SERVER['PHP_SELF']}?p=$nextpage'>></a> ";
    echo " <a href='{$_SERVER['PHP_SELF']}?p=$totalpages'>>></a> ";
} 





// закрываем соединение с сервером  базы данных
mysql_close();
error_reporting(E_ALL & ~E_DEPRECATED);
?>

		