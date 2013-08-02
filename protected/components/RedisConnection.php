<?php

class RedisConnection
{
    private $_server = 'localhost';
    private $_port = 6379;
    public static $redis = null;
    private $_content = null;

    public function __construct($content = null)
    {
        if (!self::$redis) {
            self::$redis = new Redis();
            $this->connectServer();
        }
        $this->_content = $content;
    }

    public function connectServer()
    {
        return self::$redis->connect($this->_server, $this->_port);
    }

    public static function getUserChannel($user_id)
    {
        return self::$redis->get(self::getKey($user_id));
    }

    public function checkIn($user_id)
    {
        if (!self::$redis->exists(self::getKey($user_id))) {
            self::$redis->set(self::getKey($user_id), md5(microtime() . $user_id . rand(10000, 99999)));
        }
        return $this->getUserChannel(self::getKey($user_id));
    }

    public static function getKey($user_id) {
        return 'fos_' . $user_id;
    }

    public function checkOut($user_id)
    {
        self::$redis->del($user_id);
    }

    public function publish($user_ids)
    {
        foreach ($user_ids as $user_id) {
            $channel = RedisConnection::getUserChannel($user_id);
            self::$redis->publish($channel, $this->_content);
        }
    }

}

?>
