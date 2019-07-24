 <?php

// 追加文件块
$fileName = $_FILES['uploadFile']['name'];
file_put_contents('files/' . $_POST['fileName'], file_get_contents($_FILES['uploadFile']['tmp_name']), FILE_APPEND);
