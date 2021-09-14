<?php
require 'config/config_db.php';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$limit = 15;
$page = $_POST['page'];

$stm = $pdo -> query('SELECT COUNT(*) FROM contacts'); 
$stm->execute(array($limit));
$count = $stm->fetchColumn();

$totalPage = intval(ceil($count / $limit));

if(empty($page) or $page < 0) {
    $page = 1;
}
if ($page > $totalPage) {
    $page = $totalPage;
}
$start = $page * $limit - $limit;
// echo '$page -> '.$page.'<br>';
// echo '$start -> '.$start.'<br>';
$sql = $pdo -> prepare('SELECT * FROM contacts LIMIT ?,?');
$sql -> bindParam(1,$start, PDO::PARAM_INT);
$sql -> bindParam(2,$limit, PDO::PARAM_INT);
$sql -> execute();

// if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
//     !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
//     strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
//     // Если к нам идёт Ajax запрос, то ловим его  
//    echo 'Ajax request!';
// }
$table = '';
$table.= '
<tr>
    <th>#</th>
    <th>ID</th>
    <th>title_ru</th>
    <!-- <th>description_ru</th> -->
    <th>isbn</th>
    <th>isbn2</th>
    <th>isbn3</th>
    <th>isbn4</th>
    <th>isbn_wrong</th>
</tr>
';

$i=$start+1;
while ($row = $sql->fetch(PDO::FETCH_OBJ)) { 
    $table.= '<tr>
            <td>'.$i++.'</td>
            <td>'.$row->id.'</td>
            <td>'.$row->title_ru.'</td>
            <td>'.$row->isbn.'</td>
            <td>'.$row->isbn2.'</td>
            <td>'.$row->isbn3.'</td>
            <td>'.$row->isbn4.'</td>
            <td>'.$row->isbn_wrong.'</td>
        </tr>';
}

if($page != 1) {
    $prevpage = '<a class="pagination__link" href="?page=1" title="к первой записи">&lt;&lt;</a>';
    $prevpage.= '<a class="pagination__link" href="?page='.($page-1).'">&lt;</a>';
}
if($page != $totalPage) {
    $nextpage = '<a class="pagination__link" href="?page='.($page+1).'">&gt;</a>';
    $nextpage.= '<a class="pagination__link" href="?page='.($totalPage).'" title="к последней записи ->'.$totalPage.'">&gt;&gt;</a>';
}
if ($page>2 and $page<=$totalPage-2) {
    $pagecurrent = '<span class="pagination__link active">'.($page).'</span>';
} 

if ($page-2 > 0 and ($page-2 !== $totalPage-2)) {
    $leftpage2 = '<a class="pagination__link" href="?page='.($page-2).'">'.($page-2).'</a>';
} elseif ($page-2 == 0) { 
    $leftpage2 = '<a class="pagination__link" href="?page='.($page-1).'">'.($page-1).'</a>';
} elseif ($page-2 == -1) { 
    $leftpage2 = '<a class="pagination__link active" href="?page='.($page).'">'.($page).'</a>';
} elseif ($page-2 == $totalPage-2) { 
    $leftpage2 = '<a class="pagination__link" href="?page='.($page-3).'">'.($page-3).'</a>';
}

if ($page-1 > 0 and $page-1 !== 1 and $page-1 !== $totalPage-1) {
    $leftpage1 = '<a class="pagination__link" href="?page='.($page-1).'">'.($page-1).'</a>';
} elseif ($page-1 == 1)  { 
    $leftpage1 = '<a class="pagination__link active" href="?page='.($page).'">'.($page).'</a>';
} elseif ($page-1 == 0)  { 
    $leftpage1 = '<a class="pagination__link" href="?page='.($page+1).'">'.($page+1).'</a>';
} elseif ($page-1 == $totalPage-1)  { 
    $leftpage1 = '<a class="pagination__link" href="?page='.($page-2).'">'.($page-2).'</a>';
}

if ($page+2 <=$totalPage and $page!==1 and $page!==2) {
    $rightpage2 = '<a class="pagination__link" href="?page='.($page+2).'">'.($page+2).'</a>';
} elseif ($page == $totalPage) {
    $rightpage2 = '<a class="pagination__link active" href="?page='.($page).'">'.($page).'</a>';
} elseif ($page+2 > $totalPage) {
    $rightpage2 = '<a class="pagination__link" href="?page='.($page+1).'">'.($page+1).'</a>';
} elseif ($page == 1) {
    $rightpage2 = '<a class="pagination__link" href="?page='.($page+3).'">'.($page+3).'</a>';
} elseif ($page == 2) {
    $rightpage2 = '<a class="pagination__link" href="?page='.($page+2).'">'.($page+2).'</a>';
}

if ($page+1 < $totalPage and $page!==1 and $page!==2) {
    $rightpage1 = '<a class="pagination__link" href="?page='.($page+1).'">'.($page+1).'</a>';
} elseif ($page+1 == $totalPage) {
    $rightpage1 = '<a class="pagination__link active" href="?page='.($page).'">'.($page).'</a>';
} elseif ($page == $totalPage) {
    $rightpage1 = '<a class="pagination__link" href="?page='.($page-1).'">'.($page-1).'</a>';
} elseif ($page == 1) {
    $rightpage1 = '<a class="pagination__link" href="?page='.($page+2).'">'.($page+2).'</a>';
} elseif ($page == 2) {
    $rightpage1 = '<a class="pagination__link" href="?page='.($page+1).'">'.($page+1).'</a>';
}

$pagination = $prevpage.$leftpage2.$leftpage1.$pagecurrent.$rightpage1.$rightpage2.$nextpage;

$res = [
    'table'=>$table,
    'pagination'=>$pagination
];

$res = json_encode($res);

die($res);
?>