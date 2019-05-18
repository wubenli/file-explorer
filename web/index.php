<?php

/**
 * 文件资源管理器
 *
 *
 * 声明目录扩展类
 * 传入路径
 * 判断类型
 * 列表、内容
 */

/**
 * 导入包含文件
 */
# include 'E:\www\work\wuding\php-ext\src\Directory.php';
# include 'E:\www\work\wuding\php-ext\src\Filesystem.php';
$config = include __DIR__ . '/../app/config/autoload.php';
# print_r($config);
foreach ($config as $file) {
    foreach ($file['filename'] as $filename) {
        $filepath = $file['prefix'] . $filename . $file['suffix'];
        include $filepath;
    }
}

/**
 * 配置
 */
$hosts = array(
        'composer.urlnk.host' => 'D:/env\www\work\wubenli\composer',
        'urlnk.cc' => 'D:/env\www\work\netjoin\cdn',
    );
$contentType = array(
        'css' => 'text/css',
    );

/**
 * 请求
 */
$html_tag = isset($_GET['html_tag']) ? $_GET['html_tag'] : '';


/**
 * 对象变量定义
 */
$directory = new Ext\Directory();
$filesystem = new Ext\Filesystem();
$pathinfo = $_SERVER['PATH_INFO'];
$http_host = $_SERVER['HTTP_HOST'];
$filename_ext = pathinfo($pathinfo, PATHINFO_EXTENSION);
$directory_prefix = $hosts[$http_host] . $pathinfo;

/**
 * 输出内容
 */
$str = '';
if (is_dir($directory_prefix)) {
    $directories = Ext\Directory::scandir($directory_prefix);
    $dirname = $pathinfo ? $pathinfo . '/' : '';
    foreach ($directories as $key => $value) {
        $value = $dirname . $value;
        $str .= "<li><a href='$value'>$value</a></li>";
    }
} elseif (is_file($directory_prefix)) {
    $str = Ext\Filesystem::getContents($directory_prefix);
    if ($html_tag) {
        $str = "<$html_tag>$str</$html_tag>";
    } elseif ($filename_ext && array_key_exists($filename_ext, $contentType)) {
        header("Content-Type: $contentType[$filename_ext]");
    }
}

echo $str;