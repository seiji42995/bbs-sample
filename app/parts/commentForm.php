<form class="formWrapper" method="POST">
  <div>
    <input type="hidden" name="thread_id" value="<?php echo $thread["id"]; ?>">
    <input type="submit" value="書き込む" name="submitButton">
    <label>名前：</label>
    <input type="text" name="username" value="<?php if ($thread["id"] == $comment["thread_id"])
      echo $_SESSION["username"] ?>">
  </div>
    <div>
      <textarea class="commentTextArea" name="body"></textarea>
    </div>
</form>