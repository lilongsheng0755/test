/**
 * **********************************************************************************
 *                                  文件分块上传 1.0                                *
 * **********************************************************************************
 */

/**
 * 上传类型构造方法
 * 
 * @param {type} upload
 * @returns {BlockUploads}
 */
function BlockUploads(upload) {
    /**
     * 上传方式[javascript,jquery]
     * javascript:使用XMLHttpRequest对象上传
     * jquery：使用$.ajax上传【需要加载jQuery库】
     */
    this.uploadMode = upload.uploadMode || 'javascript';

    /**
     * 上传input框绑定的ID
     */
    this.uploadFileElementId = upload.uploadFileElementId || 'upload-file';

    /**
     * 上传文件接收的post字段名
     */
    this.uploadFileFeild = upload.uploadFileFeild || 'uploadFile';

    /**
     * 接收文件上传的url地址
     */
    this.uploadUrl = upload.uploadUrl || 'upload.php';

    /**
     * 大文件分块大小
     */
    this.chunkSize = upload.chunkSize || 1024 * 1024;

    /**
     * 获取已上传的文件大小
     */
    this.getUploadSizeUrl = upload.getUploadSizeUrl || 'getUploadedSize.php';


    /**
     * 上传进度条绑定的ID
     */
    this.progressElementId = upload.ProgressElementId || 'progress';

    /**
     * 初始化上传文件
     * 检测文件是否上传了部分，实现断点续传
     * 
     * @returns {Boolean}
     */
    this.init = function () {
        let fileObj = document.getElementById(this.uploadFileElementId).files[0];
        let uploadObj = this;

        // 设置表单数据
        let fd = new FormData();
        fd.append('fileName', fileObj.name);

        if (uploadObj.uploadMode !== 'jquery') {
            let xhr = new XMLHttpRequest();
            xhr.open('post', this.getUploadSizeUrl, true);
            xhr.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    // 将字符串转化为整数
                    let start = parseInt(xhr.responseText);

                    // 设置进度条
                    let progress = document.getElementById(uploadObj.progressElementId);
                    progress.max = fileObj.size;
                    progress.value = start;

                    // 开始上传
                    uploadObj.uploadFile(start);
                }
            };
            // 向服务器发送文件名查询大小
            xhr.send(fd);
        } else {
            $.ajax({
                url: this.getUploadSizeUrl,
                type: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function (responseText) {
                    // 将字符串转化为整数
                    let start = parseInt(responseText);

                    // 设置进度条
                    let progress = document.getElementById(uploadObj.progressElementId);
                    progress.max = fileObj.size;
                    progress.value = start;

                    // 开始上传
                    uploadObj.uploadFile(start);
                }
            });
        }
        return true;
    };

    /**
     * 执行文件分块上传
     * 
     * @param {type} startSize
     * @returns {Boolean}
     */
    this.uploadFile = function (startSize) {
        // 校验文件是否上传完
        let fileObj = document.getElementById(this.uploadFileElementId).files[0];
        let uploadObj = this;
        if (startSize >= fileObj.size) {
            return true;
        }

        // 获取文件块的终止字节
        let end = (startSize + this.chunkSize > fileObj.size) ? fileObj.size : (startSize + this.chunkSize);

        // 将文件切块上传
        let fd = new FormData();
        fd.append(this.uploadFileFeild, fileObj.slice(startSize, end));
        fd.append('fileName', fileObj.name);

        // POST表单数据
        if (uploadObj.uploadMode !== 'jquery') {
            let xhr = new XMLHttpRequest();
            xhr.open('post', this.uploadUrl, true);
            xhr.onload = function () {
                if (this.readyState === 4 && this.status === 200) {
                    // 上传一块完成后修改进度条信息，然后上传下一块
                    document.getElementById(uploadObj.progressElementId).value = end;
                    uploadObj.uploadFile(end);
                }
            };
            xhr.send(fd);
        } else {
            $.ajax({
                url: this.uploadUrl,
                type: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function () {
                    // 上传一块完成后修改进度条信息，然后上传下一块
                    document.getElementById(uploadObj.progressElementId).value = end;
                    uploadObj.uploadFile(end);
                }
            });
        }
    };
}