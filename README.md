# Gravatar Proxy

本地代理 Gravatar 头像，提升加载速度的 WordPress 插件。

## 功能特性

- 本地缓存 Gravatar 头像，减少外部请求
- 自动缓存管理，支持缓存过期时间设置
- CDN 支持，可配置 CDN 加速
- 默认头像回退机制
- 简单易用，无需复杂配置

## 安装方法

### 方法一：手动安装

1. 下载插件压缩包
2. 解压到 WordPress 的 `wp-content/plugins/` 目录
3. 在 WordPress 后台启用插件

### 方法二：通过 WordPress 后台安装

1. 登录 WordPress 后台
2. 进入 插件 > 安装插件
3. 上传插件压缩包并安装
4. 启用插件

## 使用说明

插件启用后会自动工作，无需额外配置。

### 访问头像

使用以下格式访问缓存的头像：

```
https://yourdomain.com/?hash={gravatar_hash}
```

其中 `{gravatar_hash}` 是用户的 Gravatar MD5 哈希值。

## 配置选项

插件提供以下配置常量，可在 `wp-config.php` 中自定义：

```php
// 缓存目录（默认：WP_CONTENT_DIR . '/cache/gravatar'）
define('GRAVATAR_CACHE_DIR', WP_CONTENT_DIR . '/cache/gravatar');

// 缓存过期时间（默认：30天，单位：秒）
define('GRAVATAR_CACHE_EXPIRY', 30 * 24 * 60 * 60);
```

## 系统要求

- WordPress 5.0 或更高版本
- PHP 7.0 或更高版本
- 服务器支持文件写入权限

## 文件结构

```
gravatar-proxy/
├── assets/
│   └── images/
│       └── default-avatar.jpg    # 默认头像
├── includes/
│   ├── class-cache-manager.php  # 缓存管理类
│   ├── class-cdn-manager.php    # CDN 管理类
│   └── class-gravatar-proxy.php # 主插件类
├── gravatar-proxy.php           # 插件主文件
└── README.md
```

## 贡献指南

欢迎提交 Issue 和 Pull Request！

1. Fork 本仓库
2. 创建特性分支 (`git checkout -b feature/AmazingFeature`)
3. 提交更改 (`git commit -m 'Add some AmazingFeature'`)
4. 推送到分支 (`git push origin feature/AmazingFeature`)
5. 开启 Pull Request

## 许可证

本插件采用 GPL v2 或更高版本许可证。详见 [LICENSE](LICENSE) 文件。

## 作者

bobo

## 致谢

感谢所有为本项目做出贡献的开发者。

## 更新日志

### 1.0.0
- 初始版本发布
- 支持 Gravatar 头像本地缓存
- 支持缓存过期管理
- 支持默认头像回退
