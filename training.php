<?php

// потренируем регулярки
$string = "PHP56_testing";


$text = "Привет мир!";
echo strlen($text);
echo '<br>';
echo 6 / ($d = (5 % 2) - 1);echo '<br>';

$arr = array(0,1,2);
foreach ($arr as $value) {
    $value += 2;
}
print_r($arr);
?>
<ul>
<li>1 => <?print_r(preg_match("/^[A-Za-z0-9]*$/", $string));?></li>
<li>2 => <?print_r(preg_match("/^(\w)$/", $string));?></li>
<li>3 => <?print_r(preg_match("/^PHP(\w)*/", $string));?></li>
<li>4 => <?print_r(preg_match( "/56_test/", $string));?></li>
<li>5 => <?print_r(preg_match( "/[0-9]+$/", $string ));?></li>
</ul>

