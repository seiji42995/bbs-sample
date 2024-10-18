<?php

$thread_array = array();
// コメントデータ取得
$sql = "SELECT * FROM thread ORDER BY id DESC";
$statement = $pdo->prepare($sql);
$statement->execute();
$thread_array = $statement;
// var_dump($thread_array -> fetchAll());