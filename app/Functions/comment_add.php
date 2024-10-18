<?php
// エラーメッセージ格納用
$error_message = array();
session_start();

if (isset($_POST["submitButton"])) {

  // 名前入力チェック
  if (empty($_POST["username"])) {
    $error_message["username"] = "お名前を入力してください";
  } else {
    // エスケープ処理
    $escaped["username"] = htmlspecialchars($_POST["username"], ENT_QUOTES, "UTF-8");
    $_SESSION["username"] = $escaped["username"];
  }
  // コメント入力チェック
  if (empty($_POST["body"])) {
    $error_message["body"] = "コメントを入力してください";
  } else {
    // エスケープ処理
    $escaped["body"] = htmlspecialchars($_POST["body"], ENT_QUOTES, "UTF-8");
  }

  if (empty($error_message)) {
    $post_date = date("y-m-d H:i:s");

    // トランザクション開始
    $pdo->beginTransaction();
    try {
      $sql = "INSERT INTO `comment` (`username`, `body`, `post_date`, `thread_id`)
       VALUES(:username, :body, :post_date, :thread_id );";
      $statement = $pdo->prepare($sql);

      // 値をセット
      // $statement->bindParam(":username", $_POST["username"], PDO::PARAM_STR);
      // $statement->bindParam(":body", $_POST["body"], PDO::PARAM_STR);
      $statement->bindParam(":username", $escaped["username"], PDO::PARAM_STR);
      $statement->bindParam(":body", $escaped["body"], PDO::PARAM_STR);
      $statement->bindParam(":post_date", $post_date, PDO::PARAM_STR);
      $statement->bindParam(":thread_id", $_POST["thread_id"], PDO::PARAM_INT);
      $statement->execute();
      $pdo->commit();
    } catch (Exception $error) {
      $pdo->rollBack();
    }
  }
  // 掲示板ページに遷移する
  $sql = "SELECT MAX(id) FROM `comment` WHERE thread_id = :thread_id;";
  $statement = $pdo->prepare($sql);
  $statement->bindParam(":thread_id", $_POST["thread_id"], PDO::PARAM_INT);
  $statement->execute();
  $commentId = $statement->fetchAll();
  var_dump($commentId[0]["MAX(id)"]);
  header("location: http://localhost:8080/2chan-bbs#comment-" . $commentId[0]["MAX(id)"]);
  exit();
}