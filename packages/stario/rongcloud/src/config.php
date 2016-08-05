<?php

return [
    /**
     * Debug 模式，bool 值：true/false
     *
     * 当值为 false 时，所有的日志都不会记录
     */
    'debug'  => true,

    /**
     * 使用 Laravel 的缓存系统
     */
    'use_laravel_cache' => true,

    /**
     * 账号基本信息，请从开放平台获取
     */
    'app_id'  => env('RONGCLOUD_APPID', 'app_key'),         // AppID
    'secret'  => env('RONGCLOUD_SECRET', 'app_secret'),     // AppSecret

    /**
     * 日志配置
     *
     * level: 日志级别，可选为：
     *                 debug/info/notice/warning/error/critical/alert/emergency
     * file：日志文件位置(绝对路径!!!)，要求可写权限
     */
    'log' => [
        'level' => env('RONGCLOUD_LOG_LEVEL', 'debug'),
        'file'  => env('RONGCLOUD_LOG_FILE', storage_path('logs/rongcloud.log')),
    ]

];
