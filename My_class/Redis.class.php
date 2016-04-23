<?php
/**
 * Created by PhpStorm.
 * User: githup
 * Date: 2016-04-23
 * Time: 11:09
 * QQ：4873473
 */

class MyRedis extends Redis {

    public static $instance = null;  // 单例对象

    public $isConnect = false; // 判断redis是否链接成功

    public $connectMsg = ''; // redis链接信息

    public $date = null; // log记录日期

    private $config = [
        //主(master)服务器
        'master' => [
            'hostname' => '192.168.1.223',
            'password' => 'sewerew',
            'port' => '6379',
            'timeout' => '5',
        ],
        //从(slave)服务器
        'slave' => [
            'hostname' => '192.168.1.230',
            'password' => 'qweqq',
            'port' => '6379',
            'timeout' => '5',
        ]
    ];

    function __construct($params = array()) {
        parent::__construct();
        $serverArray = $this->config;

        //组装参数
        $hostname = $serverArray['master']['hostname']; //连接地址
        $password = $serverArray['master']['password']; //密码
        $port = $serverArray['master']['port']; //端口
        $timeout = $serverArray['master']['timeout']; //超时
        //选择用户指定的主机和数据库
        if (isset($params['redis']) && array_key_exists($params['redis'], $serverArray)) {
            $hostname = $serverArray[$params['redis']]['hostname']; //连接地址
            $password = $serverArray[$params['redis']]['password']; //密码
            $port = $serverArray[$params['redis']]['port']; //端口
            $timeout = $serverArray[$params['redis']]['timeout']; //超时
        }
        $this->date = date('Y-m-d', time());

        $this->_connect($hostname, $port, $timeout, $password);
    }

    /**
     *  连接数据库
     *
     * @param string $hostname  主机地址
     * @param int    $port      redis端口
     * @param int    $timeout   超时时间默认30s
     * @param string $password  验证密码
     * @param bool   $isPConnect  是否长连接：默认false非长连接
     * @return bool               返回值：成功返回true，失败false
     */
    private function _connect($hostname, $port = 6379, $timeout = 5, $password = '', $isPConnect = false) {
        //开始连接数据库
        try {
            if ($isPConnect == false) {
                $status = $this->connect($hostname, $port, $timeout);
            } else {
                $status = $this->pconnect($hostname, $port, $timeout);
            }

            if (!$status) {
                error_log(date('Y-m-d H:i:s') . ":" . 'redis connect error' . "\t",3, "./application/logs/redis-error-{$this->date}.log");
                return $this->response(false, 'redis connect error');
            }
        } catch (Exception $e) {
            error_log(date('Y-m-d H:i:s') . ":" . $e->getMessage() . "\t",3, "./application/logs/redis-error-{$this->date}.log");
            return $this->response(false, $e->getMessage());
        }

        //验证密码
        if ($password && !$this->auth($password)) {
            error_log(date('Y-m-d H:i:s') . ":" . 'redis password error' . "\t",3, "./application/logs/redis-error-{$this->date}.log");
            return $this->response(false, 'redis password error');
        }

        return $this->response(true, 'redis connect success');
    }


    public static function getInstance($params = array(), $flag = false) {
        if (!(self::$instance instanceof self) || $flag) {
            self::$instance = new self($params = array());
        }
        return self::$instance;
    }

    /**
     * 返回消息
     *
     * @param  bool   $status   状态
     * @param  string $msg      消息
     * @return void
     */
    private function response($status = false, $msg = '') {
        $this->isConnect = $status; //判断redis是否连接成功
        $this->connectMsg = $msg;  //连接redis的消息通知
        return $status;
    }

}

// 调用
$myredis = new MyRedis();

var_dump($myredis->connectMsg);die();