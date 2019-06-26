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
define('CONFIG_DIR', realpath(__DIR__ . '/../app/config'));

/**
 * 导入包含文件
 */
$config = include CONFIG_DIR . '/autoload.php';
foreach ($config as $file) {
    foreach ($file['filename'] as $filename) {
        $filepath = $file['prefix'] . $filename . $file['suffix'];
        include $filepath;
    }
    unset($file);
}

/**
 * 配置
 */
extract(include CONFIG_DIR . '/web.php');

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
} else {
    print_r([$directory_prefix, __FILE__, __LINE__]);
    exit;
}

echo $str;