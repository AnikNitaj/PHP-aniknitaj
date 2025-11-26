<?php

// $my_file = fopen("ds.txt", "w");

// fclose($my_file);

// $my_files=fopen("dss.txt", "r");

// $file=fopen("example.txt","r");

// while(!feof($file)){
//     echo fgets($file)."<br>";
// }

// fclose($file);

// $my_file = fopen("ds.txt", "w");

// $my_text = "Digital School\n";

// fwrite($my_file, $my_text);

$h=fopen("data.txt","w+");

fwrite($h,"Text test 1");

$handle=fopen("data.txt","a+");
fwrite($handle,"add more lines to this file");
fclose($handle);
?>


