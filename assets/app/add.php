<?php
// Откликаться будет ТОЛЬКО на ajax запросы
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    return;
}

if (!isset($_POST['name']) || !isset($_POST['phone']) || empty($_POST['name']) || empty($_POST['phone'])) {
    return;
}

require 'config/config_db.php';

$dsn = 'mysql:host=' . $config_db['host'] . ';dbname=' . $config_db['dbname'] . ';charset=' . $config_db['charset'];
$pdo = new PDO($dsn, $config_db['user'], $config_db['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$stm = $pdo->prepare("INSERT INTO contacts (name, phone) VALUES (:name, :phone)");

// добавляем контакт
$params = [
    'name' => htmlspecialchars($_POST['name']),
    'phone' => htmlspecialchars($_POST['phone'])
];
// print_r($params);
$stm->execute($params);

$stm = $pdo -> prepare('SELECT * FROM contacts');
$stm -> execute();
$list = '';
while ($row = $stm->fetch(PDO::FETCH_OBJ)) { 
   $list .= '<li class="contact container">
                <div class="contact-data">
                <span class="name">'.$row->name.'<span data-id="'.$row->id.'" class="delete">×</span></span>
                <span class="phone">'.$row->phone.'</span>
                </div>
            </li>';
}

$res = [
    'list'=>$list,
    'status'=>'success'
];

$res = json_encode($res);

die($res);
?>