<?php
// 设置时区，避免时间相关问题
date_default_timezone_set('Asia/Shanghai');

// 目标文件夹
$target_dir = "../upload/";

// 文件名（这里假设身份证号）
$target_file = $target_dir . basename($_FILES["photo"]["name"]);

// 允许的文件类型
$allowed_types = array("jpg", "jpeg");

// 文件大小限制
$max_file_size_kb = 180;

/**
 * 验证身份证号码是否正确
 *
 * @param string $idCard 身份证号码
 * @return bool 是否有效
 */
function validateIDCard($idCard) {
    // 验证身份证号码长度
    if (strlen($idCard) !== 18) {
        return false;
    }

    // 验证前17位是否全部为数字
    if (!ctype_digit(substr($idCard, 0, 17))) {
        return false;
    }

    // 验证第18位是否为数字或X/x
    if (!ctype_digit(substr($idCard, 17, 1)) && !in_array(strtoupper(substr($idCard, 17, 1)), ['X'])) {
        return false;
    }

    // 定义校验码
    $checkCode = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];

    // 定义系数数组
    $factorArray = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];

    // 计算校验码
    $sum = 0;
    for ($i = 0; $i < 17; $i++) {
        $sum += substr($idCard, $i, 1) * $factorArray[$i];
    }
    $mod = $sum % 11;
    $checkDigit = $checkCode[$mod];

    // 比较校验码
    if (strtoupper(substr($idCard, 17, 1)) != $checkDigit) {
        return false;
    }

    return true;
}

// 检查是否有文件上传
if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {

    // 检查上传的文件数量
    if (count($_FILES["photo"]["name"]) > 1) {
        session_start(); // 启动会话
        $_SESSION['err_message'] = "只能上传一个文件，请确认后再试";
        header("Location: result.php?error=" . urlencode("只能上传一个文件，请确认后再试"));
        exit;
    }

    // 获取文件信息
    $file_name = basename($_FILES["photo"]["name"]);
    $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_size = $_FILES["photo"]["size"] / 1024; // 转换为KB

    // 分离文件名和扩展名
    $file_base_name = pathinfo($file_name, PATHINFO_FILENAME);

    // 检查目标文件夹是否存在
    if (!is_dir($target_dir)) {
        session_start(); // 启动会话
        $_SESSION['err_message'] = "目标文件夹不存在，请联系系统管理员处理此问题";
        header("Location: result.php?error=" . urlencode("目标文件夹不存在，请联系系统管理员处理此问题"));
        exit;
    }

    // 验证文件类型
    if (!in_array($file_type, $allowed_types)) {
        $errorMessage = "只允许JPG类型的文件";
    } elseif ($file_size > $max_file_size_kb) { // 验证文件大小
        $errorMessage = "照片文件的大小不允许超过180KB";
    } elseif (!validateIDCard($file_base_name)) { // 验证身份证号码是否有效
        $errorMessage = "文件名必须是正确的身份证号码";
    } else {
        // 移动上传的文件
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // 检查文件是否成功移动到指定位置
            if (file_exists($target_file)) {
                session_start(); // 启动会话
                $_SESSION['suc_message'] = "文件 ". htmlspecialchars(basename($_FILES["photo"]["name"])). " 已上传";
                header("Location: result.php?success=文件 ". htmlspecialchars(basename($_FILES["photo"]["name"])). " 已上传");
                exit;
            } else {
                session_start(); // 启动会话
                $_SESSION['err_message'] = "上传过程中发生了错误";
                header("Location: result.php?error=" . urlencode("上传过程中发生了错误"));
            }
        } else {
            session_start(); // 启动会话
            $_SESSION['err_message'] = "上传过程中发生了错误";
            header("Location: result.php?error=" . urlencode("上传过程中发生了错误"));
        }
    }

    if (isset($errorMessage)) {
        session_start(); // 启动会话
        $_SESSION['err_message'] = $errorMessage;
        header("Location: result.php?error=" . urlencode($errorMessage));
        exit;
    }
} else {
    session_start(); // 启动会话
    $_SESSION['err_message'] = "请选择你需要上传的文件";
    header("Location: result.php?error=" . urlencode("请选择你需要上传的文件"));
    exit;
}
?>