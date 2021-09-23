<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

echo Array("1","2");
echo '<br><hr>';


$text = "Привет мир";
echo strlen($text);

echo '<br><hr>';
echo 'Что получится в результате этого кода 6 / ($d = (5 % 2) - 1)<br>';
echo 6 / ($d = (5 % 2) - 1);
echo '<br><hr>';

$arr = array(0,1,2);
foreach ($arr as $value) {
    $value += 2;
}
print_r($arr);

echo '<br><hr>';
echo 'Что выведет приведённый ниже код в PHP7.1 и более новых версиях?<br>';
function Hello($a,$b) {
    echo "Hello" .$a;
}

Hello("Vasya");
echo '<br><hr>';

// потренируем регулярки
$string = "PHP56_testing";
?>
<ul>
<li>1 => <?print_r(preg_match("/^[A-Za-z0-9]*$/", $string));?></li>
<li>2 => <?print_r(preg_match("/^(\w)$/", $string));?></li>
<li>3 => <?print_r(preg_match("/^PHP(\w)*/", $string));?></li>
<li>4 => <?print_r(preg_match( "/56_test/", $string));?></li>
<li>5 => <?print_r(preg_match( "/[0-9]+$/", $string ));?></li>
</ul>

