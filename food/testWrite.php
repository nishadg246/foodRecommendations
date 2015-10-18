<?php    
  $fp = fopen('sidebar_subscribers.txt', 'a') or die('fopen failed');

  fwrite($fp, "$name\t$email\t$leader\t$industry\t$country\t$zip\r\n") or die('fwrite failed');
?>
