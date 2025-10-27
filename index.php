<?php
/*
    Copyright Statement

    Developer: Huang Deyong (GitHub: @little-gt)
    License: MIT Agreement
 */

include './config.php';

// 检查当前时间是否超过了设定的时间
if ($currentDateTime > $cutoffDateTime) {
    session_start(); //启动session会话
    $_SESSION['err_message'] = '已过上传时间，禁止继续上传';
    header('Location: ./action/result.php');
    exit;
}

// 读取模板文件
$templatePath = './templates/template1.html';

if (file_exists($templatePath)) {
    ob_start(); // 开始输出缓冲
    include $templatePath;
    $content = ob_get_clean(); // 获取缓冲区内容
    $content = str_replace('{{university_name}}', $universityName, $content); // 替换学校名称
    $content = str_replace('{{university_logo}}', $universityLogoURL, $content); // 替换学校校徽
    $content = str_replace('{{html_background}}', $htmlBackgroundURL, $content); // 替换页面背景
    echo $content; // 输出内容
} else {
    echo "错误：无法加载模板文件";
}