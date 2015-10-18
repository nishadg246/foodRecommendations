<?php
 
  $connection = mysqli_connect("us-cdbr-azure-east2-d.cloudapp.net", "ba2928c9e0cc3a", "08b53d25", "spacepenguins");
 
  //run the store proc
  $result = mysqli_query($connection,
     "CALL get_prev()") or die("Query fail: " . mysqli_error());
 
  //loop the result set
  $l= array();
  while ($row = mysqli_fetch_array($result)){ 
  		$temp= array(); 
  		$temp[0]=$row[0];
  		$temp[1]=$row[1];
      $temp[2]=$row[2];
      $l[] = $temp;
  }
  $j = json_encode($l);
  //$myfile = fopen("prevs.txt", "w") or die("Unable to open file!");
  //$fwrite($myfile, $j);
  //$fclose($myfile);
  //file_put_contents('prevs.txt', $j);
  $filename = "/var/www/html/food/prevs.txt";
  if (!$handle = fopen($filename, 'w')) {
	echo "Cannot open file ($filename)";
	exit;
	}
  if (fwrite($handle, $j) === FALSE){
	echo "Cannot write to file ($filename)";
	exit;
	}
  fclose($handle);
  echo $j;
  mysqli_close($connection);

?>
