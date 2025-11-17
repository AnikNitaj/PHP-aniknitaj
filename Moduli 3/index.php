<?php

//$num=1;

//if($num < 0){
//    echo "$num is less then 0";
//}

//$age=21;
//if($age < 20){
//    echo "You are under 20";
//} else {
//    echo "You are an adult";
//}

//$age=15;
//if($age < 12) && ($age < 20){
//    echo "You are a teenager";
//} 

//if(($age < 12) || ($age < 20)){
//    echo "You are a adult";
//}

//$allowed = '21';


//$value = '21';

//if ($value == $allowed) {
//    echo "OK";
//} else {
//    echo "Disallowed";
//}

//$age=16;
//switch($age){
//    case ($age>=0 && $age<=18):
//        echo "You are a minor";
//        break;
//    case ($age>=18 && $age<=25):
//        echo "You are a young adult";
//        break;
//    case ($age>=25):
//        echo "You are an adult";
//        break;
//    default:
//        echo "invalid age";
//        break;

//}

// $x=1;
// while($x <= 5){
//     echo "The number is: $x <br>";
//     $x=$x+1;
// }

// do {
//     echo "The number is: $x <br>";
//     $x++;
// } while($x<=5);

for($x=0; $x<=10; $x++){
    //echo "The number is: $x <br>";
}
$cars = ("Volvo", "BMW", "Toyota");
foreach($cars as $value){
    //echo "$value <br>";
}

$age=("john"="35", "mary"="30", "joe"="34");
foreach($age as $x => $x_val){
    echo "$x = $x_val<br>";
}
?>