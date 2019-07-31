 <?php
// 接收文件名
$fileSize = 0;
if (!isset($_POST['fileName'])) {
    echo $fileSize;die;
}
$fileName = $_POST['fileName'];
$isCoverUpload = $_POST['isCoverUpload'];

$path = 'files/' . $fileName;
//查询已上传文件大小
if (file_exists($path)) {
    if($isCoverUpload){
        @unlink($path);
        echo  $fileSize;die;
    }
    $fileSize = filesize($path);
}
echo $fileSize;