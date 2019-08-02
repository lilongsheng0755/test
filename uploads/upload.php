<?php

// 检查文件是否完全上传
if ($_FILES['uploadFile']['error'] != 0) {
    header('HTTP/1.1 504 Gateway Time-out');
    exit;
}

// 校验文件名是否存在
if (!$_POST['fileName']) {
    header('HTTP/1.1 504 Gateway Time-out');
    exit;
}

// 检测上传文件类型
$ext = (string) @pathinfo($_POST['fileName'], PATHINFO_EXTENSION);
if (!in_array($ext, ['jpg', 'zip', 'gif'])) {
    header('HTTP/1.1 504 Gateway Time-out');
    exit;
}

// 追加文件块
$file_path = 'files/' . $_POST['fileName'];
while (!$fh = @fopen($file_path, 'a+')) {
    if ($fh) {
        break;
    }
    sleep(1);
}
$temp_file = $_FILES['uploadFile']['tmp_name'];
fwrite($fh, file_get_contents($temp_file));
fclose($fh);

// 如果有权限则删除临时上传的文件
if (file_exists($temp_file) && is_executable(dirname($temp_file)) && is_writable(dirname($temp_file))) {
    @unlink($temp_file);
}
