<?php
return array(
    //路由配置
    'router' => array(
        'base_action' => 'index', //默认路由入口
        'base_shell' => 'index', //默认shell入口

        //静态化配置
        'routeRule' => array(
            'index.html' => 'index',
            'up/<upid:\d+>' => 'up/detail',
            'u/<upid:\d+>' => 'up/detail',
            'd/<upid:\d+>' => 'up/feed',
            'g/<upid:\d+>' => 'gift/detail',
            'search/<keyword:[\s\S]*>' => 'search/search',
            'update_log' => 'log/update',
            'log_submit' => 'submit/log',
            'daily' => 'dailyStream',
            'custom' => 'customStream',
            'live' => 'liveStream',
            'medal/search/<keyword:[\s\S]*>' => 'medal/search',
            'ups' => 'upStream',
            'new' => 'newStream',
            'ups/prev/<day:\d+>' => 'upStream/prev',
            'daily/prev/<day:\d+>' => 'dailyStream/prev',
            'live/prev/<day:\d+>' => 'liveStream/prev',

            'api/cron/<upid:\d+>' => 'api/up_cron', //每日任务的up信息
            'api/detail/<upid:\d+>' => 'api/up_detail', //根据day来的最新信息
            'api/keyword/<keyword:[\s\S]*>' => 'api/up_search', //搜索up在数据库中信息
            'api/upStream/' => 'api/stream_upStream', //返回对应日急上升
            'api/upStream/prev/<day:\d+>' => 'api/stream_upStream/prev', //返回对应日急上升
            'api/dailyStream/<day:\d+>' => 'api/stream_dailyStream', //返回对应日总榜单
        ),
    ),

    //自动加载配置
    'autoload' => array(
        'autoPath' => 'config/autoload.php',
        //重新构建间隔时间s
        'autoSkipLoad' => 5,
        'autoThrow' => false, //使用外部autoload机制(如composer) 需设置为false
    ),

    //请求配置
    'request' => array(
        'trueToken' => 'vup-csrf',
        'csrfToken' => 'csrf-token',
        'csrfPost' => '_csrf',
        'csrfHeader' => 'X-CSRF-TOKEN',

        // 约定userIP字段 X_REAL_IP
        'userIP' => '',
        //强制返回页面协议
        'showTpl' => 'X_SHOW_TEMPLATE',
        //csrf白名单
        'csrfWhiteIps' => array(
            '127.0.0.1/24'
        ),
        // 多语言cookie字段
        'languageCookie' => 'vup_language'
    ),

    //响应配置
    'response' => array(
        'jsonContentType' => 'application/json',
        //兼容老版本 新版本都用one就可以了
        'paramsType' => 'one',  // one or keys
        // 以下配置在paramsType == one 时有效
        'paramsKey' => 'PRM',
        'objectEncode' => true, //object对象是否转义
    ),

    //日志相关配置
    'logger' => array(
        // 是否记录日志文件
        'files' => false,
        // 自定义日志记录方法
//        'sendLog' => array('Common', 'sendLog'),
        // 自定义日志错误方法
//        'sendError' => array('Common', 'sendError'),
        //错误级别
        'errorLevel' => NOTICE,
        //慢查询阀值
        'slowQuery' => 1000,
        // 日志归档
        'reorganize' => true
    ),

    // 数据库相关配置
    'database' => array(
        'returnIntOrFloat' => true, // 是否返回int或者float类型
        'returnAffectedRows' => false, // 是否返回受影响行数
    ),

    //缓存相关配置
    'cache' => array(
        'pkCache' => 'tb:%s',
        'session' => array(
            'save_handler'=>'files',  //files redis memcache
            'maxlifetime' => 86400,    //过期时间s
            'cookie_lifetime' => 86400 // cookie session_id过期时间s
        ),
        // 开启redis自动序列化存储
        'serialize' => true,
    ),

    //异常配置
    'exception' => array(
        //返回页面
        'exceptionTpl' => 'error/exception',
        'errorTpl' => 'error/msg',

        'messages' => array(
            500 => '网站有一个异常，请稍候再试',
            404 => '您访问的页面不存在',
            403 => '权限不足，无法访问'
        )
    ),



);