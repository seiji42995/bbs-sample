<?php

$comment_array = array();
// コメントデータ取得
$sql = "SELECT * FROM comment";
$statement = $pdo->prepare($sql);
$statement->execute();
$comment_array = $statement;
// var_dump($comment_array->fetchAll());