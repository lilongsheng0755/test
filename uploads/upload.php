 <?php

// 追加文件块
$fileName = $_FILES['uploadFile']['name'];
$file_path = 'files/' . $_POST['fileName'];

while(!$fh = @fopen($file_path,'a+')){
    if($fh){
        break;
    }
    sleep(1);
}
fwrite($fh,file_get_contents($_FILES['uploadFile']['tmp_name']));
fclose($fh);
