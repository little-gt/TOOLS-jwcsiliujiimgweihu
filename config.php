<?php
/**
 * 防止直接访问该文件
 */
if (basename($_SERVER['SCRIPT_FILENAME']) === 'config.php') {
    header('HTTP/1.0 400 Bad Request');
    exit('Bad request');
}

// 设定查询关闭的时间
$cutoffDateTime = '2024-09-28 22:30:00';

// 学校名称
// 输出后会自动显示为：XXX教务处
$universityName = 'GT ACADEMIC';

// 学校教务处链接
$universityJwcURL = 'https://www.garfieldtom.cool/';

// 学校教务处LOGO
// 建议图片尺寸大小为：756像素×80像素
// 为了更好地显示效果，建议使用透明背景图片，并且主色调为白色的浅色调
$universityLogoURL = 'https://cdn.garfieldtom.cool/img/sgsproject/SocialGoodSoftware.png';

// 查询页面背景设置
// 建议图片的大小不要太大，避免加载耗时过长
$htmlBackgroundURL = 'https://pic1.imgdb.cn/item/633c3dea16f2c2beb15b05e6.jpg';

// *无需修改*当前时间
$currentDateTime = date('Y-m-d H:i:s');
