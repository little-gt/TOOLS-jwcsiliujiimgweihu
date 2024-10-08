## 系统介绍

学校原本使用的四六级照片维护上传系统很简陋，而且不支持对上传的文件进行校验。重写的系统美化了UI设计，并且支持对上传的文件进行文件类型、文件大小、文件名、身份证号准确性的校验。

## 系统预览
[![pAlzOTP.png](https://s21.ax1x.com/2024/09/28/pAlzOTP.png)](https://imgse.com/i/pAlzOTP)
[![pAlzjFf.png](https://s21.ax1x.com/2024/09/28/pAlzjFf.png)](https://imgse.com/i/pAlzjFf)

## 特别注意

请务必修改网站的配置文件，添加下面*示例的*禁止访问规则，请根据具体使用目录，修改禁止访问的目录位置，防止身份证信息和照片文件被撞库下载。

```
    // 设置禁止访问数据源目录
    location ^~ /path/to/siliujiweihu/upload/ {
        return 400;
    }
```

## 使用方法

#### 1. 设置系统关闭时间

打开“index.php”，设置变量`$cutoffDateTime`为关闭查询系统的时间，注意，如果是2024年9月9日，**不能写为**“2024-9-9”，需要补全为“2024-09-09”。**时间也是同理。**

``` php
// 设定查询关闭的时间
$cutoffDateTime = '2024-09-10 08:20:00';

// 当前时间
$currentDateTime = date('Y-m-d H:i:s');
```

#### 2. 下载成功上传的照片

直接访问“/upload”文件夹即可，所有成功上传的照片都会在里面。并且文件类型、文件大小、文件名都是按照要求的，老师只需要检查照片内容合不合规即可。
