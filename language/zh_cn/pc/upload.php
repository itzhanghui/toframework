<?php
/*
 * @package HuaLang.site.
 * @copyright(c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.02
 * @edit date 2022.03.11
 * @id upload.php
 * */
defined('GATE') or die('Access Error!');
$config = array(
    'upload_file_failed' => '文件上传失败',
    'upload_size_limit' => '文件大小超过了限制',
    'upload_file_not_writable' => '文件将要保存的目录没有写入权限',
    'upload_not_allow' => '不允许上传此类文件',
    'upload_img_type_error' => '您上传的图片类型错误',
    'upload_file_format_error' => '您的文件格式错误',
    'upload_jpg' => '您的环境只允许您上传jpg形式的文件才能继续处理',
    'upload_error_1' => '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值',
    'upload_error_2' => '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值',
    'upload_error_3' => '文件只有部分被上传',
    'upload_error_4' => '没有文件被上传',
    'upload_error_5' => '文件已经存在',
    'upload_error_6' => '找不到临时文件夹',
    'upload_error_7' => '文件写入失败',
    'upload_source_error' => '您上传的图片来源不被允许',
    'upload_denied' => '您没有权限上传文件',
);
return $config;