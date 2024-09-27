<?php

session_start(); // 启动会话

// 读取模板文件
$templateErrPath = '../templates/template2.html';
$templateSucPath = '../templates/template3.html';

// 读取参数
$message = null;
if (isset($_SESSION['err_massage'])) {
    $message = $_SESSION['err_massage'];
    unset($_SESSION['err_massage']); // 清除会话中的消息数据
}
if(isset($_SESSION['suc_massage']))  {
    $message = $_SESSION['suc_massage'];
    unset($_SESSION['suc_massage']); // 清除会话中的消息数据
    // 输出成功信息
    if (file_exists($templateSucPath)) {
        ob_start(); // 开始输出缓冲
        include $templateSucPath;
        $content = ob_get_clean(); // 获取缓冲区内容
        echo str_replace('{{success_message}}', $message, $content); // 替换模板中的占位符
    } else {
        echo "错误：无法加载模板文件";
    }
    exit;
}
if($message === null)  {
    $message = '数据不存在，尝试重新操作，谢谢。';
}

// 输出错误信息
if (file_exists($templateErrPath)) {
    ob_start(); // 开始输出缓冲
    include $templateErrPath;
    $content = ob_get_clean(); // 获取缓冲区内容
    echo str_replace('{{error_message}}', $message, $content); // 替换模板中的占位符
} else {
    echo "错误：无法加载模板文件";
}