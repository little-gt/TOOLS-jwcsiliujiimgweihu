<?php
// 设定查询关闭的时间
$cutoffDateTime = '2024-09-27 21:30:00';

// 当前时间
$currentDateTime = date('Y-m-d H:i:s');

// 检查当前时间是否超过了设定的时间
if ($currentDateTime > $cutoffDateTime) {
    session_start(); //启动session会话
    $_SESSION['massage'] = '已过上传时间，禁止继续上传';
    header('Location: ./action/result.php');
    exit;
}

// 读取模板文件
$templatePath = './templates/template1.html';

if (file_exists($templatePath)) {
    ob_start(); // 开始输出缓冲
    include $templatePath;
    $content = ob_get_clean(); // 获取缓冲区内容
    echo $content; // 输出内容
} else {
    echo "错误：无法加载模板文件";
}