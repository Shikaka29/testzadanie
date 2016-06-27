    <script src='js/bootstrap.js'></script>
    <script src='js/bootstrap.min.js'></script>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
error_reporting(E_ALL & ~E_DEPRECATED);

define('DB_HOST', 'mysql.hostinger.ru');
define('DB_USER', 'u661420716_test');
define('DB_PASS', '123123');
define('DB_NAME', 'u661420716_test');

if (!mysql_connect(DB_HOST, DB_USER, DB_PASS)) {
    exit('Cannot connect to server');
}
if (!mysql_select_db(DB_NAME)) {
    exit('Cannot select database');
}

mysql_query('SET NAMES utf8');

function search ($query)
{
    $query = trim($query);
    $query = mysql_real_escape_string($query);
    $query = htmlspecialchars($query);

    if (!empty($query))
    {
        if (strlen($query) < 3) {
          
         echo '<div class="alert alert-warning" style="text-align: center">Слишком короткий поисковый запрос.</div>';
        } else if (strlen($query) > 128) {
           
            echo '<div class="alert alert-warning" style="text-align: center">Слишком длинный поисковый запрос.</div>';
        } else {
            $q = "SELECT `email`
                  FROM `email` WHERE `email` LIKE '%$query%'";

            $result = mysql_query($q);

            if (mysql_affected_rows() > 0) {
                $row = mysql_fetch_assoc($result);
                $num = mysql_num_rows($result);

                $text = '<p style="text-align:center;">По запросу <b>'.$query.'</b> найдено совпадений: '.$num.'</p>';
                echo '<div class="alert alert-info" style="text-align: center"> '.$text.' </div>';

                echo '<table class="table table-hover" style= "margin:0 auto;width:auto;border:1px solid whitesmoke;margin-top:20px;">';
                echo '<tr>';
                echo '<th>email</th>';
                echo '</tr>';
                do {
                    echo '<tr>';
                    echo '<td>' .$row['email']. '</td>';
                    echo '</tr>';

                } while ($row = mysql_fetch_assoc($result));
            } else {
            
               echo '<div class="alert alert-warning" style="text-align: center">По вашему запросу ничего не найдено.</div>';
            }
        }
    } else {
       
       echo '<div class="alert alert-warning" style="text-align: center">Задан пустой поисковый запрос.</div>';
    }

    // return $text;
}
?>
<?php
if (!empty($_POST['query'])) {
    $search_result = search ($_POST['query']);
    echo $search_result;
}
?>					