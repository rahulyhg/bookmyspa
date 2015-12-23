<?
if (file_exists('/index.ctp')) {
  rename('./index.php', './a2-default-index.php');
  header('refresh:1');
}

$ch = curl_init('http://www.a2hosting.com/ad-default-page');
curl_exec($ch); curl_close($ch);
?>
