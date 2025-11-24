<?php
// $dog = array(
//     array("Rex", 24, "Labrador", "America"),
//     array("Max", 30, "German Shepherd", "Germany"),

//     // echo $dog[0][0]; ."origin: ".$dog[0][3]; 
//     // echo $dog[1][0]; ."origin: ".$dog[2][3]; 
// );


for ($row=0;$row<2;$col++){
    echo "<p><b> Row number $row</b></p>";
    echo "<ul>";
    for ($col=0; $col<3; $col++){
        echo "<li>".[$row][$col]."</li>";
    }
    echo "</ul>";
}

$arrays=array(
    array(1,2,3),
    array(1,2,3),
    array(1,2,3)
);

for ($i=1;$i<4;$i++){
    for ($j=1;$j<4;$j++){
        echo "Array:$i Element:$j <br>";
    }
}

for($i=1;$i<5;$i++){
    for($j=1;$j<$i;$j++){
        echo "*";
    }
    echo "<br>";
}

$grade=array(
"math"=>90,
"science"=>85,
"history"=>88
);
echo "Math grade is: ".$grade["math"]. '<br>';

foreach($grade as $subject => $score){
    echo "Subject: ".$subject. " Score: ".$score. '<br>';
}

?>