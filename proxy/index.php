<?php
require('../../../../wp-blog-header.php');

$to_include=$_GET['ajaxpage'];
unset($_GET['ajaxpage']);
$_GET['zlistpage']=$_GET['page'];
unset($_GET['page']);
//$a=str_replace('index.php','',$_SERVER['PHP_SELF']);
//$to_include=str_replace($a,'',$_SERVER['REDIRECT_URL']);
$http=wj_mail_http("phpmail",$to_include);
$news = new HTTPRequest($http);
$output=$news->DownloadToString(false,true);
echo $output;
?>