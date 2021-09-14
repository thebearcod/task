<?php

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
