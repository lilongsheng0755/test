/**
 * ****************************************
 *               文件分块上传              *
 * ****************************************
 */

/**
 * 上传类型构造方法
 * 
 * @param {type} upload
 * @returns {BlockUploads}
 */
function BlockUploads(upload) {
    this.uploadMode = upload.uploadMode || 'javascript'; //上传方式[javascript,jquery]，模式使用原生：javascript，
    this.uploadFileElementId = upload.uploadFileElementId || 'upload-file'; // 上传input框绑定的ID
    this.uploadFileFeild = upload.uploadFileFeild || 'uploadFile'; // 上传文件接收的post字段名
    this.uploadUrl = upload.uploadUrl || 'upload.php'; // 接收文件上传的url地址
    this.chunkSize = upload.chunkSize || 1024 * 1024; // 大文件分块大小
    this.getUploadSizeUrl = upload.getUploadSizeUrl || 'getUploadedSize.php'; // 获取已上传的文件大小
    this.progressElementId = upload.ProgressElementId || 'progress'; // 上传进度条绑定的ID
    this.uploadFileObj = {}; // 用于存储上传文件的属性
}

/**
 * 获取上传文件属性
 * 
 * @returns {Element.files}
 */
BlockUploads.prototype.getFileInfo = function () {
    this.uploadFileObj = document.getElementById(this.uploadFileElementId).files[0];
    return this.uploadFileObj;
};

/**
 * 初始化上传文件
 * 
 * @returns {Boolean}
 */
BlockUploads.prototype.init = function () {
    let xhr = new XMLHttpRequest();
    xhr.open('post', BlockUploads.getUploadSizeUrl, true);
    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            // 将字符串转化为整数
            let start = parseInt(xhr.responseText);

            // 设置进度条
            let progress = document.getElementById(BlockUploads.progressElementId);
            progress.max = BlockUploads.uploadFileObj.size;
            progress.value = start;

            // 开始上传
            BlockUploads.uploadFile(start);
        }
    };
    // 向服务器发送文件名查询大小
    xhr.send(this.uploadFileObj.name);
    return true;
};

/**
 * 执行文件分块上传
 * 
 * @param {type} startSize
 * @returns {Boolean}
 */
BlockUploads.prototype.uploadFile = function (startSize) {
    // 校验文件是否上传完
    if (startSize >= this.uploadFileObj.size) {
        return true;
    }

    // 获取文件块的终止字节
    let end = (startSize + this.chunkSize > this.uploadFileObj.size) ? this.uploadFileObj.size : (startSize + this.chunkSize);

    // 将文件切块上传
    let fd = new FormData();
    fd.append(this.uploadFileFeild, this.uploadFileObj.slice(startSize, end));

    // POST表单数据
    let xhr = new XMLHttpRequest();
    xhr.open('post', BlockUploads.uploadUrl, true);
    xhr.onload = function () {
        if (this.readyState === 4 && this.status === 200) {
            // 上传一块完成后修改进度条信息，然后上传下一块
            document.getElementById(BlockUploads.progressElementId).value = end;
            BlockUploads.uploadFile(end);
        }
    };
    xhr.send(fd);
};

/**
 * 创建一个分块上传对象
 * {
 *	"uploadMode":"javascript", //上传方式[javascript,jquery]，模式使用原生：javascript
 *	"uploadFileElementId":"upload-file", // 上传input框绑定的ID
 *      "uploadFileFeild ":"uploadFile", // 上传文件接收的post字段名
 *      "uploadUrl":"upload.php",  // 接收文件上传的url地址
 *      "chunkSize":"1024 * 1024", // 大文件分块大小
 *      "getUploadSizeUrl":"getUploadedSize.php", // 获取已上传的文件大小
 *      "ProgressElementId":"progress" // 上传进度条绑定的ID
 * }
 * 
 * @param {type} uploadConfig
 * @returns {createBlockUploads.uploadObj|BlockUploads}
 */
function createBlockUploads(uploadConfig) {
    if (uploadObj !== 'undefine' && uploadObj instanceof uploadConfig) {
        return uploadObj;
    }
    const uploadObj = new BlockUploads(uploadConfig);
    uploadObj.getFileInfo(); // 初始化上传文件属性
    return uploadObj;
}