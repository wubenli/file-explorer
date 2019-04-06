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
 * 对象变量定义
 */
$directory = new Ext\Directory();
$filesystem = new Ext\Filesystem();
$pathinfo = $_SERVER['PATH_INFO'];
$directory_prefix = 'E:\www\work\wubenli\composer' . $pathinfo;

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
    $str = "<pre>$str</pre>";
}

echo $str;