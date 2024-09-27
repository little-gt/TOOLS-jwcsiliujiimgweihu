请老师务必注意设置本目录的NGINX配置，禁止用户访问
即，添加：
    // 设置禁止访问数据源目录
    location ^~ /path/to/siliujiweihu/upload/ {
        return 400;
    }