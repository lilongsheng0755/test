<?php

/**
 * Author: skylong
 * CreateTime: 2019-8-2 9:50:28
 * Description: 常用mime类型定义
 */
class MimeType {

    /**
     * 二进制流类型
     */
    const MIME_TYPE_BLOB = 'blob';
    const MIME_TYPE_DOC = 'doc';
    const MIME_TYPE_GIT = 'gif';
    const MIME_TYPE_GZ = 'gz';
    const MIME_TYPE_HTM = 'htm';
    const MIME_TYPE_HTML = 'html';
    const MIME_TYPE_ICO = 'ico';
    const MIME_TYPE_JFIF = 'jfif';
    const MIME_TYPE_JPG = 'jpg';
    const MIME_TYPE_PDF = 'pdf';
    const MIME_TYPE_PPT = 'ppt';
    const MIME_TYPE_TAR = 'tar';
    const MIME_TYPE_TGZ = 'tgz';
    const MIME_TYPE_TIF = 'tif';
    const MIME_TYPE_TIFF = 'tiff';
    const MIME_TYPE_TXT = 'txt';
    const MIME_TYPE_ZIP = 'zip';

    /**
     * 获取单个mime类型
     * 
     * @param string $type mime类型简写，MimeType常量已定义
     * @return string
     */
    public static function getMimeType($type) {
        $mime_type = [
            self::MIME_TYPE_BLOB => 'application/octet-stream', //二进制流
            self::MIME_TYPE_DOC  => 'application/msword',
            self::MIME_TYPE_GIT  => 'image/gif',
            self::MIME_TYPE_GZ   => 'application/x-gzip',
            self::MIME_TYPE_HTM  => 'text/html',
            self::MIME_TYPE_HTML => 'text/html',
            self::MIME_TYPE_ICO  => 'image/x-icon',
            self::MIME_TYPE_JFIF => 'image/pipeg',
            self::MIME_TYPE_JPG  => 'image/jpeg',
            self::MIME_TYPE_PDF  => 'application/pdf',
            self::MIME_TYPE_PPT  => 'application/vnd.ms-powerpoint',
            self::MIME_TYPE_TAR  => 'application/x-tar',
            self::MIME_TYPE_TGZ  => 'application/x-compressed',
            self::MIME_TYPE_TIF  => 'image/tiff',
            self::MIME_TYPE_TIFF => 'image/tiff',
            self::MIME_TYPE_TXT  => 'text/plain',
            self::MIME_TYPE_ZIP  => 'application/zip',
        ];
        return isset($mime_type[$type]) ? $mime_type[$type] : $mime_type[self::MIME_TYPE_ZIP];
    }

}
