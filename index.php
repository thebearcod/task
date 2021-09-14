<?php
require './assets/app/config/config_db.php';
$dsn = 'mysql:host=' . $config_db['host'] . ';dbname=' . $config_db['dbname'] . ';charset=' . $config_db['charset'];
$pdo = new PDO($dsn, $config_db['user'], $config_db['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тестовое задание</title>
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <main class="main">
        <div class="contacts">
            <!-- <a href="/">
                <svg id="alterra-logotype" width="203" height="68" viewBox="0 0 244 82" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M44.0473 63.5224V0H0V77.9552L44.0473 63.5224Z" fill="#F44336"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M28.7544 33.0023C28.7544 33.0023 26.8313 33.0023 23.1226 33.0023C19.4138 33.0023 13.9651 36.7253 13.9651 45.5505C13.9651 52.7668 18.2233 55.4327 22.4358 55.4327C24.8167 55.4327 28.7544 51.296 28.7544 46.3778V33.0023ZM41.4375 58.1446H28.7544V54.7892C26.6024 56.7657 22.0695 59.5695 16.9871 59.5695C11.9505 59.5695 2.42676 55.9843 2.42676 45.4126C2.42676 34.8868 14.6062 29.6469 21.6574 29.6469C28.7086 29.6469 28.7544 29.6469 28.7544 29.6469C28.7544 25.7859 28.7544 24.8666 28.7544 22.1547C28.7544 19.4888 26.8313 17.0987 23.3973 17.0987C19.9175 17.0987 15.705 19.3969 15.705 25.2803H5.58607C5.58607 21.3733 8.24173 13.7892 23.4889 13.7892C38.7818 13.7892 40.3843 20.6839 40.3843 23.7635C40.3843 26.889 40.3843 52.3991 40.3843 53.87C40.3843 56.398 41.4375 58.1446 41.4375 58.1446Z" fill="white"></path>
                </svg>        
            </a> -->
            <form class="form contact-form" name="form-add" method="POST">
                <div class="header"><div class="container">Добавить контакт</div></div>
                <div class="form-body">
                    <div class="container flex-column">
                        <div class=form-group>
                            <input class="form-control form-name" type="text" name="name" placeholder="Имя">
                            <span class="error error-name"></span>
                        </div>
                        <div class=form-group>
                            <input class="form-control form-phone" type="text" name="phone" placeholder="Телефон" autocomplete="tel">
                            <span class="error error-phone"></span>
                        </div>      
                        <input class="btn" type="submit" value="Добавить">
                    </div>
                </div>              
            </form>
            <div class="form contacts-list">
                <div class="header container">Список контактов</div>
                <ul class="list">
                    <?php
                    $sql = $pdo -> prepare('SELECT * FROM contacts');                
                    $sql -> execute();
                    while ($row = $sql->fetch(PDO::FETCH_OBJ)) { 
                        echo '<li class="contact container">
                                <div class="contact-data">
                                <span class="name">'.$row->name.'<span data-id="'.$row->id.'" class="delete">×</span></span>
                                <span class="phone">'.$row->phone.'</span>
                                </div>
                            </li>';
                    }
                    ?>
                </ul>

            </div>
        </div>
    </main>
    <script src="assets/js/main.js"></script>
</body>
</html>